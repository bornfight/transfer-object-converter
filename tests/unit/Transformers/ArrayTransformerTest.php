<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit\Transformers;

use Bornfight\TransferObjectConverter\Transformers\ArrayTransformer;
use Symfony\Component\PropertyInfo\Type;

class ArrayTransformerTest extends AbstractTransformerTest
{
    /**
     * @var ArrayTransformer
     */
    private $transformer;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $this->transformer = new ArrayTransformer();
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
     * @dataProvider valueToArrayList
     *
     * @param mixed $value
     * @param mixed $expected
     */
    public function testItShouldTransformsValueToArrayIfItCan($value, $expected, Type $type): void
    {
        $result = $this->transformer->transform($value, $type);

        verify($result)->equals($expected);
    }

    public function valueToArrayList(): array
    {
        return [
            [
                'value' => 1,
                'expected' => 1,
                'type' => new Type(Type::BUILTIN_TYPE_ARRAY),
            ],
            [
                'value' => 2.0,
                'expected' => 2.0,
                'type' => new Type(Type::BUILTIN_TYPE_ARRAY),
            ],
            [
                'value' => 'notTransforming',
                'expected' => 'notTransforming',
                'type' => new Type(Type::BUILTIN_TYPE_ARRAY),
            ],
            [
                'value' => (object) [
                    'test' => 123,
                    'dummy' => [
                        'key' => 'test',
                        'key2' => 1234567890,
                    ],
                ],
                'expected' => [
                    'test' => 123,
                    'dummy' => [
                        'key' => 'test',
                        'key2' => 1234567890,
                    ],
                ],
                'type' => new Type(Type::BUILTIN_TYPE_ARRAY),
            ],
            [
                'value' => [
                    'notTransforming' => true,
                ],
                'expected' => [
                    'notTransforming' => true,
                ],
                'type' => new Type(Type::BUILTIN_TYPE_ARRAY),
            ],
        ];
    }

    public function supportTypeList(): array
    {
        return $this->getSupportTypeList(Type::BUILTIN_TYPE_ARRAY);
    }
}
