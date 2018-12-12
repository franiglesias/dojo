<?php
declare(strict_types=1);

namespace Dojo;

use DomainException;
use InvalidArgumentException;

class Dni
{
    private const VALID_DNI_PATTERN = '/^[XYZ\d]\d{7,7}[^UIOÑ\d]$/u';
    /** @var string */
    private $dni;

    public function __construct(string $dni)
    {
        $this->checkIsValidDni($dni);

        $number = (int)substr($dni, 0, - 1);
        $letter = substr($dni, -1);

        $mod = $number % 23;

        if (($mod === 0 && $letter !== 'T')
            || ($mod === 1 && $letter !== 'R')
            || ($mod === 2 && $letter !== 'W')
        ) {
            throw new InvalidArgumentException('Invalid dni');
        }

        $this->dni = $dni;
    }

    public function __toString(): string
    {
        return $this->dni;
    }

    private function checkIsValidDni(string $dni) : void
    {
        if (!preg_match(self::VALID_DNI_PATTERN, $dni)) {
            throw new DomainException('Bad format');
        }
    }
}
