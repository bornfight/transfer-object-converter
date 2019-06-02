<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit\Transformers;

use Bornfight\TransferObjectConverter\Transformers\ObjectTransformer;
use Symfony\Component\PropertyInfo\Type;

class ObjectTransformerTest extends AbstractTransformerTest
{
    /**
     * @var ObjectTransformer
     */
    private $transformer;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $this->transformer = new ObjectTransformer();
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
     * @dataProvider valueToObjectList
     *
     * @param mixed $value
     * @param mixed $expected
     */
    public function testItShouldTransformsValueToObjectIfItCan($value, $expected, Type $type): void
    {
        $result = $this->transformer->transform($value, $type);

        verify($result)->equals($expected);
    }

    public function valueToObjectList(): array
    {
        return [
            [
                'value' => 1,
                'expected' => 1,
                'type' => new Type(Type::BUILTIN_TYPE_OBJECT),
            ],
            [
                'value' => 2.0,
                'expected' => 2.0,
                'type' => new Type(Type::BUILTIN_TYPE_OBJECT),
            ],
            [
                'value' => 'notTransforming',
                'expected' => 'notTransforming',
                'type' => new Type(Type::BUILTIN_TYPE_OBJECT),
            ],
            [
                'value' => (object) [
                    'test' => 123,
                    'dummy' => [
                        'key' => 'test',
                        'key2' => 1234567890,
                    ],
                ],
                'expected' => (object) [
                    'test' => 123,
                    'dummy' => [
                        'key' => 'test',
                        'key2' => 1234567890,
                    ],
                ],
                'type' => new Type(Type::BUILTIN_TYPE_OBJECT),
            ],
            [
                'value' => [
                    'transforming' => true,
                    'keys' => [
                        'key' => 1234567890,
                        'key2' => 'transforming',
                        'key3' => [
                            'notTransformingToObject' => [],
                        ],
                    ],
                ],
                'expected' => (object) [
                    'transforming' => true,
                    'keys' => [
                        'key' => 1234567890,
                        'key2' => 'transforming',
                        'key3' => [
                            'notTransformingToObject' => [],
                        ],
                    ],
                ],
                'type' => new Type(Type::BUILTIN_TYPE_OBJECT),
            ],
        ];
    }

    public function supportTypeList(): array
    {
        return $this->getSupportTypeList(Type::BUILTIN_TYPE_OBJECT);
    }
}
