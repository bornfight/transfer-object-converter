<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Factory;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

interface PropertyAccessorFactoryInterface
{
    public function createPropertyAccessor(): PropertyAccessorInterface;
}
