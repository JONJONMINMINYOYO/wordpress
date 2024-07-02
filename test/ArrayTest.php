<?php
use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertCount(0, $stack);

        $stack[] = 'fooaaa';
        $this->assertEquals('fooaaa', $stack[count($stack) - 1]);
        $this->assertCount(1, $stack);

        $this->assertEquals('fooaaa', array_pop($stack));
        $this->assertCount(0, $stack);
    }
}
