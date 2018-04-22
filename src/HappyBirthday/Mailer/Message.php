<?php
declare (strict_types=1);

namespace Dojo\HappyBirthday\Mailer;

class Message
{
    /** @var string */
    private $subject;
    /** @var string */
    private $to;

    public function withSubject(string $subject) : self
    {
        $this->subject = $subject;

        return $this;
    }

    public function sendTo(string $email) : self
    {
        $this->to = $email;

        return $this;
    }

    public function subject() : string
    {
        return $this->subject;
    }

    public function to() : string
    {
        return $this->to;
    }
}
