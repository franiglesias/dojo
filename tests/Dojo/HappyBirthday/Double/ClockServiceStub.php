<?php
declare (strict_types=1);

namespace Tests\Dojo\HappyBirthday\Double;

use DateTimeImmutable;
use DateTimeInterface;
use Dojo\HappyBirthday\Clock\ClockService;

class ClockServiceStub implements ClockService
{
    /** @var DateTimeImmutable */
    private $dateTime;

    public function __construct(DateTimeInterface $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function currentDate() : DateTimeImmutable
    {
        return $this->dateTime;
    }
}
