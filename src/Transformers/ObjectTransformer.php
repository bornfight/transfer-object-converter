<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Transformers;

use Symfony\Component\PropertyInfo\Type;

class ObjectTransformer implements ValueTransformerInterface
{
    public function supports(Type $type): bool
    {
        return $type->getBuiltinType() === Type::BUILTIN_TYPE_OBJECT && $type->getClassName() === null;
    }

    /**
     * @param mixed $value
     *
     * @return object
     */
    public function transform($value, Type $type)
    {
        if (is_array($value) === true) {
            return (object) $value;
        }

        return $value;
    }
}
