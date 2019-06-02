<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Transformers;

use Bornfight\TransferObjectConverter\Exceptions\TypeClassDoesNotExistException;
use Symfony\Component\PropertyInfo\Type;

class ClassTransformer implements ValueTransformerInterface
{
    public function supports(Type $type): bool
    {
        return $type->getBuiltinType() === Type::BUILTIN_TYPE_OBJECT && $type->getClassName() !== null;
    }

    /**
     * @param mixed $value
     *
     * @return object
     */
    public function transform($value, Type $type)
    {
        $className = $type->getClassName();
        if ($className === null) {
            throw new TypeClassDoesNotExistException();
        }

        return new $className($value);
    }
}
