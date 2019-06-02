<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter;

use Bornfight\TransferObjectConverter\DependencyInjection\TransformObjectConverterExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TransferObjectConverterBundle extends Bundle
{
    /**
     * @return TransformObjectConverterExtension
     */
    public function getContainerExtension(): TransformObjectConverterExtension
    {
        return new TransformObjectConverterExtension();
    }
}
