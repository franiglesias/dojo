<?php
declare (strict_types=1);

namespace Dojo\HappyBirthday\Clock;


use DateTimeImmutable;

interface ClockService
{
    public function currentDate() : DateTimeImmutable;
}
