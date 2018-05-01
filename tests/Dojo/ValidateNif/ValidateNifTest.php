<?php
declare (strict_types=1);

namespace Tests\Dojo\ValidateNif;

use Dojo\ValidateNif;
use PHPUnit\Framework\TestCase;

class ValidateNifTest extends TestCase
{
    /** @var ValidateNif */
    private $validateNif;

    public function setUp()
    {
        $this->validateNif = new ValidateNif();
    }

    public function testShouldValidateAValidNif()
    {
        $nif = '36101628T';
        $this->assertTrue($this->validateNif->do($nif));
    }

    public function testTooLongStringsAreNotValid()
    {
        $nif = '000000000T';
        $this->assertFalse($this->validateNif->do($nif));
    }

    public function testTooShortStringsAreNotValid()
    {
        $nif = '0000000T';
        $this->assertFalse($this->validateNif->do($nif));
    }

    public function testLastCharIsNotAlfabeticalIsInvalid()
    {
        $nif = '000000000';
        $this->assertFalse($this->validateNif->do($nif));
    }

    public function testFirstCharIsNotAllowedAlfaIsInvalid()
    {
        $nif = 'A0000000T';
        $this->assertFalse($this->validateNif->do($nif));
    }

    public function testNonNumericCharsINTheMiddeleIsInvalid()
    {
        $nif = '00abc000T';
        $this->assertFalse($this->validateNif->do($nif));
    }

    public function testBadControlDigitShoulfBeInvalid()
    {
        $nif = '00000001T';
        $this->assertFalse($this->validateNif->do($nif));
    }

    /** @dataProvider validNIFS */
    public function testShouldBeValidNifs($nif)
    {
        $this->assertTrue($this->validateNif->do($nif));
    }

    public function validNIFS()
    {
        return [
            'T' => ['00000000T'],
            'R' => ['00000001R'],
            'W' => ['00000002W'],
            'A' => ['00000003A'],
            'G' => ['00000004G'],
            'M' => ['00000005M'],
            'Y' => ['00000006Y'],
            'F' => ['00000007F'],
            'P' => ['00000008P'],
            'D' => ['00000009D'],
            'X' => ['00000010X'],
            'B' => ['00000011B'],
            'N' => ['00000012N'],
            'J' => ['00000013J'],
            'Z' => ['00000014Z'],
            'S' => ['00000015S'],
            'Q' => ['00000016Q'],
            'V' => ['00000017V'],
            'H' => ['00000018H'],
            'L' => ['00000019L'],
            'C' => ['00000020C'],
            'K' => ['00000021K'],
            'E' => ['00000022E']
        ];
    }

    /** @dataProvider validNIES */
    public function testShouldBeValidNies($nif)
    {
        $this->assertTrue($this->validateNif->do($nif));
    }

    public function validNIES()
    {
        return [
            'XT' => ['X0000000T'],
            'YZ' => ['Y0000000Z'],
            'ZM' => ['Z0000000M']
        ];
    }

    /** @dataProvider invalidNIFS */
    public function testInvalidLetters($nif)
    {
        $this->assertFalse($this->validateNif->do($nif));
    }

    public function invalidNIFS()
    {
        return [
            'I' => ['00000000I'],
            'O' => ['00000000O'],
            'U' => ['00000000U'],
            'Ñ' => ['00000000Ñ']
        ];
    }
}
