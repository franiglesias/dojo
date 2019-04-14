<?php
declare(strict_types=1);

namespace Tests\Dojo;

use Dojo\Dni;
use DomainException;
use \InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DniTest extends TestCase
{
    public function testShouldNotHaveMoreThanMaxChars(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $dni = new Dni('1234567890');
    }

    public function testShouldNotHaveLessThanMinChars(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $dni = new Dni('12345678');
    }

    public function testShouldNotEndWithNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $dni = new Dni('123456789');
    }

    public function testShouldHaveNoLettersInTheMiddle(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $dni = new Dni('1234J678X');
    }

    public function testShouldNotStartWithALetterExceptXYZ(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $dni = new Dni('T2345678X');
    }

    public function testShouldFailWithInvalidDNI(): void
    {
        $this->expectException(DomainException::class);
        $dni = new Dni('00000000S');
    }

}
