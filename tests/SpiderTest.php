<?php
namespace Dannetrichard\Spider\Tests;

use Dannetrichard\Spider\Tests\TestCase;

use Dannetrichard\Spider\Spider;

class SpiderTest extends TestCase
{
    /**
     * Check that the multiply method returns correct result
     * @return void
     */
    public function testMultiplyReturnsCorrectValue()
    {
        $this->assertSame(Spider::multiply(4, 4), 16);
        $this->assertSame(Spider::multiply(2, 9), 18);
    }
}