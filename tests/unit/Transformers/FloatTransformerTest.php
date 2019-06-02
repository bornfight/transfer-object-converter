<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit\Transformers;

use Bornfight\TransferObjectConverter\Transformers\FloatTransformer;
use Symfony\Component\PropertyInfo\Type;

class FloatTransformerTest extends AbstractTransformerTest
{
    /**
     * @var FloatTransformer
     */
    private $transformer;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $this->transformer = new FloatTransformer();
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
     * @dataProvider valueToFloatList
     *
     * @param mixed $value
     * @param mixed $expected
     */
    public function testItShouldTransformsValueToFloatIfItCan($value, $expected, Type $type): void
    {
        $result = $this->transformer->transform($value, $type);

        verify($result)->equals($expected);
    }

    public function valueToFloatList(): array
    {
        return [
            [
                'value' => '1.234',
                'expected' => 1.234,
                'type' => new Type(Type::BUILTIN_TYPE_FLOAT),
            ],
            [
                'value' => 2,
                'expected' => 2.0,
                'type' => new Type(Type::BUILTIN_TYPE_FLOAT),
            ],

            [
                'value' => 3.45678,
                'expected' => 3.45678,
                'type' => new Type(Type::BUILTIN_TYPE_FLOAT),
            ],
            [
                'value' => '3a',
                'expected' => '3a',
                'type' => new Type(Type::BUILTIN_TYPE_FLOAT),
            ],
        ];
    }

    public function supportTypeList(): array
    {
        return $this->getSupportTypeList(Type::BUILTIN_TYPE_FLOAT);
    }
}
