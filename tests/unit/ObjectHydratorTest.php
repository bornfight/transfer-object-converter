<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit;

use Bornfight\TransferObjectConverter\Exceptions\PropertiesNotExtractedException;
use Bornfight\TransferObjectConverter\Factory\PropertyAccessorFactory;
use Bornfight\TransferObjectConverter\Factory\PropertyInfoExtractorFactory;
use Bornfight\TransferObjectConverter\ObjectHydrator;
use Bornfight\TransferObjectConverter\Tests\_support\TargetObjectTestClass;
use Bornfight\TransferObjectConverter\ValueTransformerAdapter;
use Codeception\Test\Unit;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class ObjectHydratorTest extends Unit
{
    private const FILE_PATH = './tests/_data/test-file.txt';
    private const FILE_ORIGINAL_NAME = 'Test file.txt';

    /**
     * @var ObjectHydrator
     */
    private $objectHydrator;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $this->objectHydrator = new ObjectHydrator(
            new ValueTransformerAdapter(),
            $this->createPropertyAccessorFactory(),
            $this->createPropertyInfoExtractorFactory()
        );
    }

    public function testItShouldHydrateObject(): void
    {
        $request = $this->getRequest();
        $targetClassName = TargetObjectTestClass::class;

        $expected = $this->getExpectedTargetClass();

        $result = $this->objectHydrator->hydrate($request, $targetClassName);

        verify($result)->equals($expected);
    }

    public function testItShouldThrowExceptionWhenReflectionClassCannotBeCreated(): void
    {
        $request = new Request();
        try {
            $result = $this->objectHydrator->hydrate($request, 'NonExistingClass');
        } catch (Throwable $ex) {
            $result = $ex;
        }

        verify($result)->isInstanceOf(PropertiesNotExtractedException::class);
    }

    private function getRequest(): Request
    {
        $query = [];
        $request = [
            'bool' => $this->getBoolean(),
            'int' => $this->getInt(),
            'float' => $this->getFloat(),
            'nonNullableFloat' => null,
            'string' => $this->getString(),
            'array' => $this->getArray(),
            'boolean' => $this->getBoolean(),
            'object' => $this->getObject(),
            'plain' => $this->getString(),
        ];
        $attributes = [];
        $cookies = [];
        $files = [
            'file' => $this->getFile(),
        ];

        return new Request(
            $query,
            $request,
            $attributes,
            $cookies,
            $files
        );
    }

    private function getExpectedTargetClass(): TargetObjectTestClass
    {
        $item = new TargetObjectTestClass();

        $item->setBool($this->getBoolean());
        $item->setInt($this->getInt());
        $item->setFloat($this->getFloat());
        $item->setString($this->getString());
        $item->setArray($this->getArray());
        $item->setObject($this->getObject());
        $item->setFile($this->getFile());
        $item->setPlain($this->getString());

        return $item;
    }

    private function getBoolean(): bool
    {
        return true;
    }

    private function getInt(): int
    {
        return 1;
    }

    private function getFloat(): float
    {
        return 1.234567;
    }

    private function getString(): string
    {
        return 'test';
    }

    private function getArray(): array
    {
        return [
            'test' => 1,
        ];
    }

    private function getObject(): object
    {
        return (object) $this->getArray();
    }

    private function getFile(): UploadedFile
    {
        return new UploadedFile(self::FILE_PATH, self::FILE_ORIGINAL_NAME);
    }

    private function createPropertyAccessorFactory(): PropertyAccessorFactory
    {
        return new PropertyAccessorFactory();
    }

    private function createPropertyInfoExtractorFactory(): PropertyInfoExtractorFactory
    {
        return new PropertyInfoExtractorFactory();
    }
}
