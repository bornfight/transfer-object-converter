<?php

declare(strict_types=1);

namespace Bornfight\TransferObjectConverter\Tests\_support;

class CoordinatesTestClass
{
    private const SINGLE_COORDINATE_PATTERN = '#^([0-9]+)\.([0-9]+)$#';

    private $latitude;
    private $longitude;

    public function __construct(string $coordinates)
    {
        $this->convert($coordinates);
    }

    private function convert(string $coordinates): void
    {
        list($latitude, $longitude) = explode(',', $coordinates);
        if (!preg_match(self::SINGLE_COORDINATE_PATTERN, $latitude)) {
            throw new \Exception('Lattitude cannot be found');
        } elseif (!preg_match(self::SINGLE_COORDINATE_PATTERN, $longitude)) {
            throw new \Exception('Longitude cannot be found');
        }
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}
