<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Transformers;

use Symfony\Component\PropertyInfo\Type;

class ArrayTransformer implements ValueTransformerInterface
{
    public function supports(Type $type): bool
    {
        return $type->getBuiltinType() === Type::BUILTIN_TYPE_ARRAY;
    }

    /**
     * @param mixed $value
     *
     * @return array
     */
    public function transform($value, Type $type)
    {
        if (is_object($value) === true) {
            return (array) $value;
        }

        return $value;
    }
}
