<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit\Transformers;

use Bornfight\TransferObjectConverter\Exceptions\TypeClassDoesNotExistException;
use Bornfight\TransferObjectConverter\Tests\_support\CoordinatesTestClass;
use Bornfight\TransferObjectConverter\Transformers\ClassTransformer;
use Symfony\Component\PropertyInfo\Type;
use Throwable;

class ClassTransformerTest extends AbstractTransformerTest
{
    /**
     * @var ClassTransformer
     */
    private $transformer;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $this->transformer = new ClassTransformer();
    }

    /**
     * @dataProvider supportTypeList
     */
    public function testItShouldSupportOnlyCertainType(Type $type, bool $expected): void
    {
        $result = $this->transformer->supports($type);

        verify($result)->equals($expected);
    }

    /**
     * @dataProvider valueToClassList
     *
     * @param mixed $value
     * @param mixed $expected
     */
    public function testItShouldTransformsValueToObjectIfItCan($value, $expected, Type $type): void
    {
        $result = $this->transformer->transform($value, $type);

        verify($result)->equals($expected);
    }

    public function testItShouldThrowExceptionWhenTypeHasNoTargetClass(): void
    {
        $typeWithNoExistingTargetClass = new Type(Type::BUILTIN_TYPE_OBJECT, false, null);

        try {
            $result = $this->transformer->transform('test string', $typeWithNoExistingTargetClass);
        } catch (Throwable $ex) {
            $result = $ex;
        }

        verify($result)->isInstanceOf(TypeClassDoesNotExistException::class);
    }

    public function valueToClassList(): array
    {
        return [
            [
                'value' => '12.34567890,23.4567890',
                'expected' => $this->getExpectedCoordinates('12.34567890', '23.4567890'),
                'type' => new Type(Type::BUILTIN_TYPE_OBJECT, false, CoordinatesTestClass::class),
            ],
            [
                'value' => '45.34567890,45.4567890',
                'expected' => $this->getExpectedCoordinates('45.34567890', '45.4567890'),
                'type' => new Type(Type::BUILTIN_TYPE_OBJECT, false, CoordinatesTestClass::class),
            ],
        ];
    }

    public function supportTypeList(): array
    {
        return $this->getSupportTypeList(Type::BUILTIN_TYPE_OBJECT, CoordinatesTestClass::class);
    }

    private function getExpectedCoordinates(string $latitude, string $longitude): CoordinatesTestClass
    {
        return new CoordinatesTestClass(sprintf('%s,%s', $latitude, $longitude));
    }
}
