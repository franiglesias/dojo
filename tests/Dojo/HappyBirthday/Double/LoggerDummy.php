<?php
declare (strict_types=1);

namespace Tests\Dojo\HappyBirthday\Double;

use Dojo\HappyBirthday\Logger\SimpleLogger;

class LoggerDummy implements SimpleLogger
{
    public function log(string $channel, string $message) : void
    {
    }
}
