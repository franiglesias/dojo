<?php
declare (strict_types=1);

namespace Tests\Dojo\Luhn;

use Dojo\Luhn\LuhnValidator;
use PHPUnit\Framework\TestCase;

class LuhnValidatorTest extends TestCase
{
    public function testShouldValidateAllZeros(): void
    {
        $validator = new LuhnValidator();
        $this->assertTrue($validator->isValid('00000000000'));
    }

    public function testShouldConsiderFirstPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00000000001'));
    }

    public function testShouldConsiderThirdPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00000000100'));
    }

    public function testShouldValidateTwoEvenPositionsAddingTen(): void
    {
        $validator = new LuhnValidator();
        $this->assertTrue($validator->isValid('00000000406'));
    }

    public function testShouldConsiderFifthPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00000010000'));
    }

    public function testShouldConsiderSeventhPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00001000000'));
    }

    public function testShouldConsiderNinthPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00100000000'));
    }

    public function testShouldConsiderEleventhPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('10000000000'));
    }

    public function testShouldConsiderSecondPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00000000010'));
    }

    public function testShouldConsiderFourthPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00000001000'));
    }

    public function testShouldConsiderSixthPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00000100000'));
    }

    public function testShouldConsiderEighthPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00010000000'));
    }

    public function testShouldConsiderTenthPosition(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('01000000000'));
    }

    public function testShouldConsiderDoubleDigitEvenAdded(): void
    {
        $validator = new LuhnValidator();
        $this->assertFalse($validator->isValid('00000000050'));
    }
}
