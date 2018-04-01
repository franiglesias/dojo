<?php


namespace Tests\Dojo\TestDoubles;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

interface Mailer
{
    public function send(Message $message) : void;
}

class MailerSpy implements Mailer
{
    private $calls = 0;

    public function send(Message $message) : void
    {
        $this->calls++;
    }

    public function getCalls()
    {
        return $this->calls;
    }
}

class ServiceTest extends TestCase implements Mailer
{
    private $mailerCalls = 0;

    public function testMailer()
    {
        $sut = new Service($this);
        $sut->execute();
        $this->assertEquals(2, $this->getCalls());
    }

    public function send(Message $message) : void
    {
        $this->mailerCalls++;
    }
}