<?php
declare(strict_types=1);

namespace Dojo;

use DomainException;

class Dni
{
    private const DNI_LENGTH = 9;

    public function __construct(string $dni)
    {
        if (!preg_match('/^[0-9XYZ]\d{7,7}[A-Z]$/', $dni)) {
            throw new \InvalidArgumentException('Bad Symbols');
        }

        throw new DomainException('Invalid DNI');
    }
}
