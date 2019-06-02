<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit\Transformers;

use Bornfight\TransferObjectConverter\Transformers\IntegerTransformer;
use Symfony\Component\PropertyInfo\Type;

class IntegerTransformerTest extends AbstractTransformerTest
{
    /**
     * @var IntegerTransformer
     */
    private $transformer;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $this->transformer = new IntegerTransformer();
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
     * @dataProvider valueToIntegerList
     *
     * @param mixed $value
     * @param mixed $expected
     */
    public function testItShouldTransformsValueToIntegerIfItCan($value, $expected, Type $type): void
    {
        $result = $this->transformer->transform($value, $type);

        verify($result)->equals($expected);
    }

    public function valueToIntegerList(): array
    {
        return [
            [
                'value' => '1',
                'expected' => 1,
                'type' => new Type(Type::BUILTIN_TYPE_INT),
            ],
            [
                'value' => '2.0',
                'expected' => 2,
                'type' => new Type(Type::BUILTIN_TYPE_INT),
            ],

            [
                'value' => 3,
                'expected' => 3,
                'type' => new Type(Type::BUILTIN_TYPE_INT),
            ],
            [
                'value' => '3a',
                'expected' => '3a',
                'type' => new Type(Type::BUILTIN_TYPE_INT),
            ],
        ];
    }

    public function supportTypeList(): array
    {
        return $this->getSupportTypeList(Type::BUILTIN_TYPE_INT);
    }
}
