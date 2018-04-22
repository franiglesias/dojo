<?php
declare (strict_types=1);

namespace Tests\Dojo\HappyBirthday;

use DateTimeImmutable;
use Dojo\HappyBirthday\Clock\ClockService;
use Dojo\HappyBirthday\Customer\Customer;
use Dojo\HappyBirthday\Customer\CustomerRepository;
use Dojo\HappyBirthday\Logger\SimpleLogger;
use Dojo\HappyBirthday\Mailer\Mailer;
use Dojo\HappyBirthday\SendGreetings;
use PHPUnit\Framework\TestCase;
use Tests\Dojo\HappyBirthday\Double\ClockServiceStub;
use Tests\Dojo\HappyBirthday\Double\LoggerDummy;
use Tests\Dojo\HappyBirthday\Double\MailerSpy;

class SendGreetingsTest extends TestCase
{

    public function testSendGreetingToCustomersWhenIsTheirBirthday() : void
    {
        $clockService = $this->getClockServiceStub();
        $customerRepository = $this->getCustomerRepositoryMock([
            new Customer('cust1@example.com'),
            new Customer('cust2@example.com'),
            new Customer('cust3@example.com')
        ]);
        $mailer = $this->getMailerSpy();
        $logger = $this->getLoggerDummy();

        $sendGreetings = new SendGreetings(
            $clockService,
            $customerRepository,
            $mailer,
            $logger
        );
        $sendGreetings->execute();

        $this->assertEquals(3, $mailer->getMessagesSent());
    }

    private function getClockServiceStub() : ClockService
    {
        return new ClockServiceStub(new DateTimeImmutable('2018-04-15'));
    }

    private function getCustomerRepositoryMock(array $customers) : CustomerRepository
    {
        $clockService = $this->getClockServiceStub();

        $customerRepositoryProphet = $this->prophesize(CustomerRepository::class);
        $customerRepositoryProphet
            ->findAllByBirthday($clockService->currentDate())
            ->shouldBeCalled()
            ->willReturn($customers);

        return $customerRepositoryProphet->reveal();
    }

    private function getMailerSpy() : Mailer
    {
        return new MailerSpy();
    }

    private function getLoggerDummy() : SimpleLogger
    {
        return new LoggerDummy();
    }
}
