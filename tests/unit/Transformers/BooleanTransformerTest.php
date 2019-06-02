<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit\Transformers;

use Bornfight\TransferObjectConverter\Transformers\BooleanTransformer;
use Symfony\Component\PropertyInfo\Type;

class BooleanTransformerTest extends AbstractTransformerTest
{
    /**
     * @var BooleanTransformer
     */
    private $transformer;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $this->transformer = new BooleanTransformer();
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
     * @dataProvider valueToBooleanList
     *
     * @param mixed $value
     * @param mixed $expected
     */
    public function testItShouldTransformsValueToBooleanIfItCan($value, $expected, Type $type): void
    {
        $result = $this->transformer->transform($value, $type);

        verify($result)->equals($expected);
    }

    public function valueToBooleanList(): array
    {
        return [
            [
                'value' => '1',
                'expected' => true,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],
            [
                'value' => 2,
                'expected' => true,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],

            [
                'value' => 0x12,
                'expected' => true,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],
            [
                'value' => '3a',
                'expected' => true,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],
            [
                'value' => '0',
                'expected' => false,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],
            [
                'value' => '',
                'expected' => false,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],
            [
                'value' => 0,
                'expected' => false,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],
            [
                'value' => null,
                'expected' => false,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],
            [
                'value' => '-1',
                'expected' => true,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],
            [
                'value' => 0x00,
                'expected' => false,
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
            ],
        ];
    }

    public function supportTypeList(): array
    {
        return $this->getSupportTypeList(Type::BUILTIN_TYPE_BOOL);
    }
}
