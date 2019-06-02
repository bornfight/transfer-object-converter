<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit\Transformers;

use Bornfight\TransferObjectConverter\Transformers\StringTransformer;
use Symfony\Component\PropertyInfo\Type;

class StringTransformerTest extends AbstractTransformerTest
{
    /**
     * @var StringTransformer
     */
    private $transformer;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $this->transformer = new StringTransformer();
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
                'value' => 1,
                'expected' => '1',
                'type' => new Type(Type::BUILTIN_TYPE_INT),
            ],
            [
                'value' => 2.0,
                'expected' => '2',
                'type' => new Type(Type::BUILTIN_TYPE_INT),
            ],

            [
                'value' => [],
                'expected' => [],
                'type' => new Type(Type::BUILTIN_TYPE_INT),
            ],
            [
                'value' => (object) [],
                'expected' => (object) [],
                'type' => new Type(Type::BUILTIN_TYPE_INT),
            ],
        ];
    }

    public function supportTypeList(): array
    {
        return $this->getSupportTypeList(Type::BUILTIN_TYPE_STRING);
    }
}
