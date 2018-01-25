<?php

namespace Larapulse\NewRelic\Tests;

use Larapulse\NewRelic\NewRelic;
use Larapulse\NewRelic\NewRelicBlackhole;
use Larapulse\NewRelic\NewRelicFactory;
use Larapulse\NewRelic\NewRelicInterface;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /**
     * Test NewRelic initialization
     */
    public function testInit()
    {
        $newRelic = NewRelicFactory::initialize('Test', 'test', false);

        $this->assertInstanceOf(NewRelicInterface::class, $newRelic);
        $this->assertTrue($newRelic instanceof NewRelicInterface);

        extension_loaded('newrelic') && $this->assertInstanceOf(NewRelic::class, $newRelic);
        !extension_loaded('newrelic') && $this->assertInstanceOf(NewRelicBlackhole::class, $newRelic);
    }
}
