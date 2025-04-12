<?php

namespace FizzBuzz\Tests\Value;

use FizzBuzz\Value\Number;
use PHPUnit\Framework\TestCase;

class NumberTest extends TestCase
{
    /**
     * Test that creating a number with a valid value works
     */
    public function testCreateValidNumber(): void
    {
        $number = new Number(5);
        $this->assertEquals(5, $number->getValue());
    }

    /**
     * Test that creating a number with an invalid value throws an exception
     */
    public function testCreateInvalidNumber(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Number must be greater than 0');

        new Number(0);
    }

    /**
     * Test that isDivisibleBy works correctly
     */
    public function testIsDivisibleBy(): void
    {
        $number = new Number(15);

        $this->assertTrue($number->isDivisibleBy(3));
        $this->assertTrue($number->isDivisibleBy(5));
        $this->assertFalse($number->isDivisibleBy(7));
    }

    /**
     * Test that creating a range of numbers works
     */
    public function testRange(): void
    {
        $numbers = Number::range(1, 5);

        $this->assertCount(5, $numbers);
        $this->assertEquals(1, $numbers[0]->getValue());
        $this->assertEquals(5, $numbers[4]->getValue());
    }

    /**
     * Test that creating an invalid range throws an exception
     */
    public function testInvalidRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Start number cannot be greater than end number');

        Number::range(5, 1);
    }
}
