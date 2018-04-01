<?php

namespace Tests\Dojo\TestDoubles;

use Dojo\TestDoubles\SomeService;
use Tests\Dojo\TestDoubles\DummyLogger;
use PHPUnit\Framework\TestCase;

class SomeServiceTest extends TestCase
{
    public function testSomeServiceCanBeInstantiated()
    {
        $logger = new DummyLogger();
        $someService = new SomeService($logger);
        $this->assertInstanceOf(SomeService::class, $someService);
    }
}
