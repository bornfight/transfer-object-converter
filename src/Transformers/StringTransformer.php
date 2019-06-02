<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Transformers;

use Symfony\Component\PropertyInfo\Type;

class StringTransformer implements ValueTransformerInterface
{
    public function supports(Type $type): bool
    {
        return $type->getBuiltinType() === Type::BUILTIN_TYPE_STRING;
    }

    /**
     * @param mixed $value
     *
     * @return string|mixed
     */
    public function transform($value, Type $type)
    {
        if (is_array($value) === true || is_object($value) === true) {
            return $value;
        }

        return (string) $value;
    }
}
