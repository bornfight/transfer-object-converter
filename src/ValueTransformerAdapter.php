<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter;

use Bornfight\TransferObjectConverter\Exceptions\TypeTransformNotSupportedException;
use Bornfight\TransferObjectConverter\Transformers\ArrayTransformer;
use Bornfight\TransferObjectConverter\Transformers\BooleanTransformer;
use Bornfight\TransferObjectConverter\Transformers\ClassTransformer;
use Bornfight\TransferObjectConverter\Transformers\FloatTransformer;
use Bornfight\TransferObjectConverter\Transformers\IntegerTransformer;
use Bornfight\TransferObjectConverter\Transformers\ObjectTransformer;
use Bornfight\TransferObjectConverter\Transformers\StringTransformer;
use Bornfight\TransferObjectConverter\Transformers\ValueTransformerInterface;
use Symfony\Component\PropertyInfo\Type;
use Throwable;

final class ValueTransformerAdapter
{
    /**
     * @var ValueTransformerInterface[]
     */
    private $transformers;

    /**
     * @param string[] $transformers
     */
    public function __construct(array $transformers = [])
    {
        $this->transformers = $this->createTransformers(
            array_merge(
                $transformers,
                $this->getDefaultTransformers()
            )
        );
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function transform(string $name, $value, ?Type $type)
    {
        if ($type === null || $value === null) {
            return $value;
        }
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($type) === false) {
                continue;
            }
            try {
                return $transformer->transform($value, $type);
            } catch (Throwable $ex) {
                return $value;
            }
        }

        $message = sprintf('There is no supported property "%s" type to transform: %s', $name, $type->getBuiltinType());
        throw new TypeTransformNotSupportedException($message);
    }

    /**
     * @param string[] $transformerClassNames
     *
     * @return ValueTransformerInterface[]
     */
    private function createTransformers(array $transformerClassNames): array
    {
        $constructed = [];
        foreach ($transformerClassNames as $className) {
            $constructed[] = new $className();
        }

        return $constructed;
    }

    private function getDefaultTransformers(): array
    {
        return [
            BooleanTransformer::class,
            IntegerTransformer::class,
            FloatTransformer::class,
            StringTransformer::class,
            ArrayTransformer::class,
            ObjectTransformer::class,
            ClassTransformer::class,
        ];
    }
}
