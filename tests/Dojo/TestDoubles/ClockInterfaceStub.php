<?php


namespace Tests\Dojo\TestDoubles;


use DateTimeImmutable;

interface ClockServiceInterface
{
    public function getCurrentDateTime() : DateTimeImmutable;
}

class ClockServiceStub implements ClockServiceInterface
{
    /**
     * @var DateTimeImmutable
     */
    private $date;

    public function __construct(string $dateString)
    {
        $this->date = new DateTimeImmutable($dateString);
    }

    public function getCurrentDateTime() : DateTimeImmutable
    {
        return $this->date;
    }
}

$dateForTesting = new ClockServiceStub('2018-03-12');