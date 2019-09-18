<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Factory;

use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;

interface PropertyInfoExtractorFactoryInterface
{
    public function createPropertyInfoExtractor(): PropertyInfoExtractorInterface;
}
