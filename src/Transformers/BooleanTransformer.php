<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Transformers;

use Symfony\Component\PropertyInfo\Type;

class BooleanTransformer implements ValueTransformerInterface
{
    public function supports(Type $type): bool
    {
        return $type->getBuiltinType() === Type::BUILTIN_TYPE_BOOL;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function transform($value, Type $type)
    {
        if (is_string($value) === false && is_numeric($value) === false && is_bool($value) === false) {
            return $value;
        }

        return (bool) $value;
    }
}
