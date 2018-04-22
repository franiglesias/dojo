<?php
declare (strict_types=1);

namespace Dojo\HappyBirthday\Mailer;

interface Mailer
{
    public function send(Message $message) : int;
}
