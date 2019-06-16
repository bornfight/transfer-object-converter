<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Factory;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class PropertyAccessorFactory implements PropertyAccessorFactoryInterface
{
    public function createPropertyAccessor(): PropertyAccessorInterface
    {
        return PropertyAccess::createPropertyAccessorBuilder()->getPropertyAccessor();
    }
}
