<?php
declare (strict_types=1);

namespace Dojo\Luhn;

class LuhnValidator
{

    public function isValid(string $luhnCode) : bool
    {
        $inverted = strrev($luhnCode);

        $oddAdded = $this->addOddDigits($inverted);
        $evenAdded = $this->addEvenDigits($inverted);

        return ($oddAdded + $evenAdded) % 10 === 0;
    }

    private function addOddDigits(string $inverted) : int
    {
        $oddAdded = 0;
        for ($position = 0; $position < 11; $position += 2) {
            $oddAdded += (int) $inverted[ $position ];
        }

        return $oddAdded;
    }

    private function addEvenDigits(string $inverted) : int
    {
        $evenAdded = 0;
        for ($position = 1; $position < 11; $position += 2) {
            $double = (int) $inverted[ $position ] * 2;
            $evenAdded += $this->reduceToOneDigit($double);
        }

        return $evenAdded;
    }

    private function reduceToOneDigit($double) : int
    {
        if ($double >= 10) {
            $double = intdiv($double, 10) + $double % 10;
        }

        return $double;
    }
}
