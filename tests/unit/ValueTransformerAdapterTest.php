<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit;

use Bornfight\TransferObjectConverter\Exceptions\TypeTransformNotSupportedException;
use Bornfight\TransferObjectConverter\ValueTransformerAdapter;
use Codeception\Test\Unit;
use DateTime;
use Symfony\Component\PropertyInfo\Type;
use Throwable;

class ValueTransformerAdapterTest extends Unit
{
    private const PROPERTY_NAME = 'testPropertyName';
    /**
     * @var ValueTransformerAdapter
     */
    private $valueTransformerAdapter;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $this->valueTransformerAdapter = new ValueTransformerAdapter();
    }

    /**
     * @dataProvider exampleList
     *
     * @param mixed $value
     * @param mixed $expected
     */
    public function testItShouldTransformValues(string $name, $value, ?Type $type, $expected): void
    {
        $result = $this->valueTransformerAdapter->transform($name, $value, $type);

        verify($result)->equals($expected);
    }

    public function testItShouldThrowExceptionWhenTypeIsNotSupported(): void
    {
        $name = self::PROPERTY_NAME;
        $value = function () {};
        $type = new Type(Type::BUILTIN_TYPE_CALLABLE);
        try {
            $result = $this->valueTransformerAdapter->transform($name, $value, $type);
        } catch (Throwable $ex) {
            $result = $ex;
        }

        verify($result)->isInstanceOf(TypeTransformNotSupportedException::class);
    }

    public function exampleList(): array
    {
        return [
            [
                'name' => self::PROPERTY_NAME,
                'value' => '1',
                'type' => new Type(Type::BUILTIN_TYPE_INT),
                'expected' => 1,
            ],
            [
                'name' => self::PROPERTY_NAME,
                'value' => '201a9-0c7-01a',
                'type' => new Type(Type::BUILTIN_TYPE_OBJECT, false, DateTime::class),
                'expected' => '201a9-0c7-01a',
            ],
        ];
    }
}
