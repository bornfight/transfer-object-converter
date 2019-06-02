<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter;

use Bornfight\TransferObjectConverter\Exceptions\PropertiesNotExtractedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

class ObjectHydrator
{
    /**
     * @var PropertyInfoExtractorInterface
     */
    private $propertyInfoExtractor;
    /**
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;
    /**
     * @var ValueTransformerAdapter
     */
    private $transformerAdapter;

    public function __construct(
        ValueTransformerAdapter $transformerAdapter,
        PropertyAccessorInterface $propertyAccessor = null,
        PropertyInfoExtractorInterface $propertyInfoExtractor = null
    ) {
        $this->transformerAdapter = $transformerAdapter;
        // TODO need to introduce factory for each of these
        $this->propertyAccessor = $propertyAccessor ?? $this->createPropertyAccessor();
        $this->propertyInfoExtractor = $propertyInfoExtractor ?? $this->createPropertyInfoExtractor();
    }

    public function hydrate(Request $request, string $className): object
    {
        $properties = $this->propertyInfoExtractor->getProperties($className);
        if (is_iterable($properties) === false) {
            throw new PropertiesNotExtractedException();
        }

        $object = new $className();

        foreach ($properties as $property) {
            $type = $this->getPropertyType($className, $property);
            $value = $this->getPropertyValueFromRequest($property, $type, $request);
            if ($value === null && $type !== null && $type->isNullable() === false) {
                continue;
            }
            $this->propertyAccessor->setValue($object, $property, $value);
        }

        return $object;
    }

    private function getPropertyType(string $className, string $property): ?Type
    {
        $types = $this->propertyInfoExtractor->getTypes($className, $property);
        if ($types === null || isset($types[0]) === false) {
            return null;
        }

        return $types[0];
    }

    /**
     * @return mixed
     */
    private function getPropertyValueFromRequest(string $property, ?Type $type, Request $request)
    {
        if ($type !== null && $type->getClassName() === UploadedFile::class) {
            return $request->files->get($property);
        }
        $value = $request->request->get($property);

        return $this->transformerAdapter->transform($property, $value, $type);
    }

    private function createPropertyInfoExtractor(): PropertyInfoExtractorInterface
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

    private function createPropertyAccessor(): PropertyAccessorInterface
    {
        return PropertyAccess::createPropertyAccessorBuilder()
            ->getPropertyAccessor();
    }
}
