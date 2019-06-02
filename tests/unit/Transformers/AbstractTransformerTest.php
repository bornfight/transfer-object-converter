<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit\Transformers;

use Codeception\Test\Unit;
use Symfony\Component\PropertyInfo\Type;

abstract class AbstractTransformerTest extends Unit
{
    protected function getSupportTypeList(string $supportedType, ?string $className = null): array
    {
        return [
            [
                'type' => new Type(Type::BUILTIN_TYPE_BOOL),
                'expected' => $supportedType === Type::BUILTIN_TYPE_BOOL,
            ],
            [
                'type' => new Type(Type::BUILTIN_TYPE_INT),
                'expected' => $supportedType === Type::BUILTIN_TYPE_INT,
            ],
            [
                'type' => new Type(Type::BUILTIN_TYPE_FLOAT),
                'expected' => $supportedType === Type::BUILTIN_TYPE_FLOAT,
            ],
            [
                'type' => new Type(Type::BUILTIN_TYPE_STRING),
                'expected' => $supportedType === Type::BUILTIN_TYPE_STRING,
            ],
            [
                'type' => new Type(Type::BUILTIN_TYPE_ARRAY),
                'expected' => $supportedType === Type::BUILTIN_TYPE_ARRAY,
            ],
            [
                'type' => new Type(Type::BUILTIN_TYPE_OBJECT, false, $className),
                'expected' => $supportedType === Type::BUILTIN_TYPE_OBJECT,
            ],
            [
                'type' => new Type(Type::BUILTIN_TYPE_CALLABLE),
                'expected' => $supportedType === Type::BUILTIN_TYPE_CALLABLE,
            ],
            [
                'type' => new Type(Type::BUILTIN_TYPE_ITERABLE),
                'expected' => $supportedType === Type::BUILTIN_TYPE_ITERABLE,
            ],
            [
                'type' => new Type(Type::BUILTIN_TYPE_RESOURCE),
                'expected' => $supportedType === Type::BUILTIN_TYPE_RESOURCE,
            ],
            [
                'type' => new Type(Type::BUILTIN_TYPE_NULL),
                'expected' => $supportedType === Type::BUILTIN_TYPE_NULL,
            ],
        ];
    }
}
