<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit\DependencyInjection;

use Bornfight\TransferObjectConverter\DependencyInjection\TransformObjectConverterExtension;
use Codeception\Test\Unit;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Throwable;

class TransformObjectConverterExtensionTest extends Unit
{
    public function testItNotThrowAnyException(): void
    {
        $extension = $this->getExtension();
        $containerBuilder = $this->getContainerBuilder();

        $result = null;
        try {
            $extension->load([], $containerBuilder);
        } catch (Throwable $ex) {
            $result = $ex;
        }
        verify($result)->null();
    }

    private function getExtension(): TransformObjectConverterExtension
    {
        return new TransformObjectConverterExtension();
    }

    private function getContainerBuilder(): ContainerBuilder
    {
        return new ContainerBuilder();
    }
}
