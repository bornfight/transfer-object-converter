<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Transformers;

use Symfony\Component\PropertyInfo\Type;

class IntegerTransformer implements ValueTransformerInterface
{
    public function supports(Type $type): bool
    {
        return $type->getBuiltinType() === Type::BUILTIN_TYPE_INT;
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    public function transform($value, Type $type)
    {
        if (is_int($value) === true) {
            return $value;
        } elseif (is_float($value) === true || is_numeric($value) === true) {
            return (int) $value;
        }

        return $value;
    }
}
