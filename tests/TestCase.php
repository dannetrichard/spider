<?php

namespace Dannetrichard\Spider\Tests;

use Dannetrichard\Spider\Spider;
use Orchestra\Testbench\TestCase as TestBenchTestCase;

class TestCase extends TestBenchTestCase
{
    protected function getPackageProviders($app)
    {
        return ['Dannetrichard\Spider\SpiderServiceProvider'];
    }

    public function testMultiplyReturnsCorrectValue()
    {
        $this->assertSame(Spider::multiply(4, 4), 16);
        $this->assertSame(Spider::multiply(2, 9), 18);
    }
}
