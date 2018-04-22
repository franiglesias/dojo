<?php
declare (strict_types=1);

namespace Dojo\HappyBirthday\Logger;


interface SimpleLogger
{
    public function log(string $channel, string $message) : void;
}
