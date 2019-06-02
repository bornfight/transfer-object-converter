<?php

/** @noinspection PhpIncompatibleReturnTypeInspection */

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\unit;

use Bornfight\TransferObjectConverter\ObjectHydrator;
use Bornfight\TransferObjectConverter\Tests\_support\TargetObjectTestClass;
use Bornfight\TransferObjectConverter\TransferObjectConverter;
use Bornfight\TransferObjectConverter\ValueTransformerAdapter;
use Codeception\Test\Unit;
use Codeception\Util\Stub;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class TransferObjectConverterTest extends Unit
{
    private const VALUE_INT = 1;
    private const VALUE_BOOL = true;
    private const VALUE_FLOAT = 1234.56789;
    private const VALUE_STRING = 'test-string';
    /**
     * @var TransferObjectConverter
     */
    private $transferObjectConverter;
    /**
     * @var TransferObjectConverter
     */
    private $transferObjectConverterWithoutValidator;

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _before(): void
    {
        $objectHydrator = $this->getObjectHydrator();
        $validator = $this->getValidator();

        $this->transferObjectConverter = new TransferObjectConverter($objectHydrator, $validator);
        $this->transferObjectConverterWithoutValidator = new TransferObjectConverter($objectHydrator);
    }

    public function testItShouldSupportConversion(): void
    {
        $configuration = $this->getParamConverterConfiguration();

        $result = $this->transferObjectConverter->supports($configuration);

        verify($result)->true();
    }

    public function testItShouldNotSupportConversion(): void
    {
        $configuration = $this->getParamConverterConfiguration([
            'name' => 'Not supported name',
            'class' => '',
        ]);

        $result = $this->transferObjectConverter->supports($configuration);

        verify($result)->false();
    }

    public function testItShouldProduceObject(): void
    {
        $configuration = $this->getParamConverterConfiguration();

        $request = $this->getRequest();

        $expected = $this->getExpectedValidResult();

        $this->transferObjectConverter->apply($request, $configuration);

        $result = $request->attributes->get($configuration->getName());

        verify($result)->equals($expected);
    }

    public function testItShouldProduceObjectWithoutValidatingIt(): void
    {
        $configuration = $this->getParamConverterConfiguration();

        $request = $this->getRequest();

        $expected = $this->getExpectedValidResult();

        $this->transferObjectConverterWithoutValidator->apply($request, $configuration);

        $result = $request->attributes->get($configuration->getName());

        verify($result)->equals($expected);
    }

    public function testItShouldThrowExceptionWhenTargetClassIsNotDefined(): void
    {
        $configuration = $this->getParamConverterConfiguration([
            'class' => '',
        ]);

        $request = $this->getRequest();

        $result = null;
        $resultMessage = null;
        try {
            $this->transferObjectConverter->apply($request, $configuration);
        } catch (Throwable $ex) {
            $result = $ex;
            $resultMessage = $ex->getMessage();
        }

        verify($result)->isInstanceOf(NotAcceptableHttpException::class);
        verify($resultMessage)->equals(sprintf('It seems that argument (%s) which you want to populate has no class defined. This can happen if you set different argument name in @ParamConverter than it is named in method argument.', TargetObjectTestClass::class));
    }

    private function getObjectHydrator(): ObjectHydrator
    {
        $valueTransformerAdapter = new ValueTransformerAdapter();

        return new ObjectHydrator(
            $valueTransformerAdapter
        );
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    private function getValidator(): ValidatorInterface
    {
        /** @var ValidatorInterface $validator */
        $validator = Stub::makeEmpty(ValidatorInterface::class, [
            'validate' => function () {
                return new ConstraintViolationList();
            },
        ]);

        return $validator;
    }

    private function getParamConverterConfiguration(array $configuration = []): ParamConverter
    {
        return new ParamConverter(array_merge([
            'name' => TargetObjectTestClass::class,
            'converter' => TransferObjectConverter::NAME,
            'class' => TargetObjectTestClass::class,
        ], $configuration));
    }

    private function getRequest(): Request
    {
        return new Request(
            [],
            [
                'bool' => self::VALUE_BOOL,
                'int' => self::VALUE_INT,
                'float' => self::VALUE_FLOAT,
                'string' => self::VALUE_STRING,
            ],
            [],
            [],
            []
        );
    }

    private function getExpectedValidResult(): TargetObjectTestClass
    {
        $item = new TargetObjectTestClass();
        $item->setBool(self::VALUE_BOOL);
        $item->setInt(self::VALUE_INT);
        $item->setFloat(self::VALUE_FLOAT);
        $item->setString(self::VALUE_STRING);

        return $item;
    }
}
