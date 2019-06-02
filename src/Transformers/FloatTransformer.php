<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Transformers;

use Symfony\Component\PropertyInfo\Type;

class FloatTransformer implements ValueTransformerInterface
{
    public function supports(Type $type): bool
    {
        return $type->getBuiltinType() === Type::BUILTIN_TYPE_FLOAT;
    }

    /**
     * @param mixed $value
     *
     * @return float
     */
    public function transform($value, Type $type)
    {
        if (is_string($value) === false || is_numeric($value) === false) {
            return $value;
        }

        return (float) $value;
    }
}
