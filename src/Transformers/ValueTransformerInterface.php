<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Transformers;

use Symfony\Component\PropertyInfo\Type;

interface ValueTransformerInterface
{
    public function supports(Type $type): bool;

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function transform($value, Type $type);
}
