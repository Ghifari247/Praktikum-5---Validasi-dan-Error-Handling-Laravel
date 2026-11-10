<?php

namespace Modules\Catalog\ValueObjects;

use InvalidArgumentException;

class ISBN
{
    private string $value;

    public function __construct(string $value)
    {
        $value = str_replace('-', '', $value);

        if (!preg_match('/^(97[89])?\d{9}[\dX]$/', $value)) {
            throw new InvalidArgumentException('Format ISBN tidak valid');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}