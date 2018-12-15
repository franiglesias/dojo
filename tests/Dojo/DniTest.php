<?php
declare(strict_types=1);

namespace Tests\Dojo;

use Dojo\Dni;
use DomainException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DniTest extends TestCase
{
    public function testShouldFailWhenDniLongerThanMaxLenght() : void
    {
        $this->expectException(DomainException::class);
        $dni = new Dni('0123456789');
    }

    public function testShouldFailWhenDniShorterThanMinLenght() : void
    {
        $this->expectException(DomainException::class);
        $dni = new Dni('01234567');
    }

    public function testShouldFailWhenDniEndsWithANumber() : void
    {
        $this->expectException(DomainException::class);
        $dni = new Dni('012345678');
    }

    public function testShouldFailWhenDniEndsWithAnInvalidLetter() : void
    {
        $this->expectException(DomainException::class);
        $dni = new Dni('01234567I');
    }

    public function testShouldFailWhenDniHasLettersInTheMiddle() : void
    {
        $this->expectException(DomainException::class);
        $dni = new Dni('012AB567R');
    }

    public function testShouldFailWhenDniStartsWithALetterOtherThanXYZ() : void
    {
        $this->expectException(DomainException::class);
        $dni = new Dni('A1234567R');
    }

    public function testShouldFailWhenInvalidDni() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $dni = new Dni('00000000S');
    }

    public function testShouldConstructValidDNIEndingWithT() : void
    {
        $dni = new Dni('00000000T');
        $this->assertEquals('00000000T', (string) $dni);
    }

    public function testShouldConstructValidDNIEndingWithR() : void
    {
        $dni = new Dni('00000001R');
        $this->assertEquals('00000001R', (string) $dni);
    }

    public function testShouldConstructValidDNIEndingWithW() : void
    {
        $dni = new Dni('00000002W');
        $this->assertEquals('00000002W', (string) $dni);
    }

    public function testShouldConstructValidNIEStartingWithX() : void
    {
        $dni = new Dni('Y0000000Z');
        $this->assertEquals('Y0000000Z', (string) $dni);
    }

    public function testShouldConstructValidDNIWithLowerCaseLetter(): void
    {
        $dni = new Dni('00000002w');
        $this->assertEquals('00000002W', (string) $dni);
    }
}
