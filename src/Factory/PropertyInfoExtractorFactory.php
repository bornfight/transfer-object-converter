<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Factory;

use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;

class PropertyInfoExtractorFactory implements PropertyInfoExtractorFactoryInterface
{
    public function createPropertyInfoExtractor(): PropertyInfoExtractorInterface
    {
        $reflectionExtractor = new ReflectionExtractor();
        $phpDocExtractor = new PhpDocExtractor();

        return new PropertyInfoExtractor(
            [
                $reflectionExtractor,
            ],
            [
                $reflectionExtractor,
                $phpDocExtractor,
            ],
            [
                $phpDocExtractor,
            ],
            [
                $reflectionExtractor,
            ],
            [
                $reflectionExtractor,
            ]
        );
    }
}
