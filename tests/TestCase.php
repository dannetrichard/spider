<?php

use Orchestra\Testbench\TestCase as TestBenchTestCase;
class TestCase extends TestBenchTestCase
{
    protected function getPackageProviders($app)
    {
        return ['Dannetrichard\Spider\SpiderServiceProvider'];
    }
}