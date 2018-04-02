<?php


namespace Dojo\MailerExample\Application;


interface Mailer
{
    public function send(Message $message);
}
