<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TransferObjectConverter implements ParamConverterInterface
{
    public const NAME = 'bornfight.transfer_object_converter.converter';

    private const CONSTRAINT_VIOLAION_LIST_NAME = 'constraintViolationList';
    /**
     * @var ValidatorInterface|null
     */
    private $validator;

    /**
     * @var ObjectHydrator
     */
    private $objectHydrator;
    /**
     * @var string
     */
    private $constraintViolationListName;

    public function __construct(
        ObjectHydrator $objectHydrator,
        ValidatorInterface $validator = null,
        string $constraintViolationListName = self::CONSTRAINT_VIOLAION_LIST_NAME
    ) {
        $this->objectHydrator = $objectHydrator;
        $this->validator = $validator;
        $this->constraintViolationListName = $constraintViolationListName;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $object = $this->objectHydrator->hydrate($request, $configuration->getClass());

        $request->attributes->set($configuration->getName(), $object);

        if ($this->validator === null || strlen($this->constraintViolationListName) === 0) {
            return true;
        }

        $constraintViolationList = $this->validator->validate($object);

        $request->attributes->set(
            $this->constraintViolationListName,
            $constraintViolationList
        );

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        $targetClassName = $configuration->getClass() ?? '';
        if (strlen($targetClassName) === 0 || $configuration->getConverter() !== self::NAME) {
            return false;
        }

        return true;
    }
}
