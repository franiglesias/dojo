<?php

namespace Tests\Dojo\Mailer;

use Dojo\MailerExample\Application\SendNotificationService;

use PHPUnit\Framework\TestCase;

interface Mailer
{
    public function send(Message $message): bool;
}

class SuccessfulMailerStub implements Mailer
{
    public function send(Message $message): bool
    {
        return true;
    }
}

class FailedMailerStub implements Mailer
{
    public function send(Message $message): bool
    {
        throw new MailServiceDownException();
    }
}

interface Message
{
    public function subject(): string;
    public function body(): string;
}

class MessageStub implements Message
{
    public function subject(): string
    {
        return 'Subject';
    }
    public function body(): string
    {
        return 'Body';
    }
}

class SendNotificationServiceTest extends TestCase
{
    private $message;

    public function setUp() : void
    {
        $this->message = new MessageStub();
    }

    public function testSendNotificationCanSendAMessage() : void
    {
        $mailer = new SuccessfulMailerStub();

        $sendNotification = new SendNotificationService($mailer);
        $this->assertTrue($sendNotification->send($this->message));
    }

    public function testSendNotificationCanNotSendMessage() : void
    {
        $this->expectException(NotiicationCouldNotBeSent::class);
        $mailer = new FailedMailerStub();

        $sendNotification = new SendNotificationService($mailer);
        $sendNotification->send($this->message);
    }
}
