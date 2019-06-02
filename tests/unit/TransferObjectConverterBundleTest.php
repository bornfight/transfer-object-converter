<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit;

use Bornfight\TransferObjectConverter\DependencyInjection\TransformObjectConverterExtension;
use Bornfight\TransferObjectConverter\TransferObjectConverterBundle;
use Codeception\Test\Unit;

class TransferObjectConverterBundleTest extends Unit
{
    public function testItShouldGetContainerExtension(): void
    {
        $bundle = $this->getBundle();

        $result = $bundle->getContainerExtension();

        verify($result)->isInstanceOf(TransformObjectConverterExtension::class);
    }

    private function getBundle(): TransferObjectConverterBundle
    {
        return new TransferObjectConverterBundle();
    }
}
