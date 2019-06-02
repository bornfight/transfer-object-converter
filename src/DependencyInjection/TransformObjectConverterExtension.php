<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\DependencyInjection;

use Bornfight\TransferObjectConverter\ObjectHydrator;
use Bornfight\TransferObjectConverter\ValueTransformerAdapter;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class TransformObjectConverterExtension extends Extension
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(
                __DIR__ . '/../Resources/config'
            )
        );
        $loader->load('services.yaml');

        $this->addAnnotatedClassesToCompile([
            ObjectHydrator::class,
            ValueTransformerAdapter::class,
        ]);
    }
}
