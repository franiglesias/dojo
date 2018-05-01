<?php
declare (strict_types=1);

namespace Dojo;

class ValidateNif
{

    private const NIF_FORMAT = '/^[\dxyz]\d{7,7}[a-z]$/i';

    private const CONTROL_DIGITS = 'trwagmyfpdxbnjzsqvhlcke';

    private const MAGIC_DIVISOR = 23;

    private const NIE_STARTING_LETTERS = ['x', 'y', 'z'];

    private const NIE_STARTING_LETTERS_REPLACEMENTS = [0, 1, 2];

    public function do(string $nif) : bool
    {
        $nif = strtolower($nif);

        if (!$this->nifHasTheRightFormat($nif)) {
            return false;
        }

        if ($this->controlDigitIsCorrect($nif)) {
            return true;
        }

        return false;
    }

    private function controlDigitIsCorrect(string $nif) : bool
    {
        $modulus = $this->calculateModulusOfNumberPart($nif);

        return substr($nif, -1) === self::CONTROL_DIGITS[ $modulus ];
    }

    private function calculateModulusOfNumberPart(string $nif) : int
    {
        $numberPart = str_replace(
            self::NIE_STARTING_LETTERS,
            self::NIE_STARTING_LETTERS_REPLACEMENTS,
            substr($nif, 0, 8)
        );
        $modulus = ((int) $numberPart) % self::MAGIC_DIVISOR;

        return $modulus;
    }

    private function nifHasTheRightFormat(string $nif)
    {
        return preg_match(self::NIF_FORMAT, $nif);
    }
}
