<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\_support;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class TargetObjectTestClass
{
    /**
     * @Assert\Type(type="boolean")
     */
    private $bool;
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     * @Assert\GreaterThan(value="0")
     */
    private $int;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     */
    private $float;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     */
    private $nonNullableFloat;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="6", max="16")
     */
    private $string;

    /**
     * @Assert\NotBlank()
     */
    private $array;
    /**
     * @Assert\NotBlank()
     */
    private $object;
    /**
     * @Assert\NotBlank()
     * @Assert\File()
     */
    private $file;

    private $plain;

    public function getBool(): bool
    {
        return $this->bool;
    }

    public function setBool(?bool $value): void
    {
        $this->bool = $value;
    }

    public function getInt(): int
    {
        return $this->int;
    }

    public function setInt(?int $value): void
    {
        $this->int = $value;
    }

    public function getFloat(): float
    {
        return $this->float;
    }

    public function setFloat(?float $value): void
    {
        $this->float = $value;
    }

    public function getString(): string
    {
        return $this->string;
    }

    public function setString(?string $value): void
    {
        $this->string = $value;
    }

    public function getArray(): array
    {
        return $this->array;
    }

    public function setArray(?array $value): void
    {
        $this->array = $value;
    }

    public function getObject(): object
    {
        return $this->object;
    }

    public function setObject(?object $value): void
    {
        $this->object = $value;
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): void
    {
        $this->file = $file;
    }

    public function setPlain($value): void
    {
        $this->plain = $value;
    }

    public function getPlain()
    {
        return $this->plain;
    }

    public function getNonNullableFloat(): float
    {
        return $this->nonNullableFloat;
    }

    public function setNonNullableFloat(float $value): void
    {
        $this->nonNullableFloat = $value;
    }
}
