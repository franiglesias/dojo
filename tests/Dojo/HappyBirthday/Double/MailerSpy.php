<?php
declare (strict_types=1);

namespace Tests\Dojo\HappyBirthday\Double;

use Dojo\HappyBirthday\Mailer\Mailer;
use Dojo\HappyBirthday\Mailer\Message;

class MailerSpy implements Mailer
{

    private $messagesSent = 0;

    public function send(Message $message) : int
    {
        $this->messagesSent++;

        return 1;
    }

    public function getMessagesSent() : int
    {
        return $this->messagesSent;
    }
}
