<?php

namespace Tests;

use FizzBuzz\FizzBuzz;
use FizzBuzz\Rules\BazzRule;
use FizzBuzz\Rules\BuzzRule;
use FizzBuzz\Rules\FizzRule;
use FizzBuzz\Value\Number;
use PHPUnit\Framework\TestCase;

class FizzBuzzTest extends TestCase
{
    private FizzBuzz $fizzBuzz;
    
    protected function setUp(): void
    {
        $this->fizzBuzz = new FizzBuzz([
            new FizzRule(),
            new BuzzRule(),
            new BazzRule()
        ]);
    }
    
    public function testProcessNumberReturnsNumberForNonDivisibleNumber(): void
    {
        $result = $this->fizzBuzz->process(new Number(1));
        $this->assertEquals('1', $result->getOutput());
    }
    
    public function testProcessNumberReturnsFizzForNumberDivisibleByThree(): void
    {
        $result = $this->fizzBuzz->process(new Number(3));
        $this->assertEquals('Fizz', $result->getOutput());
    }
    
    public function testProcessNumberReturnsBuzzForNumberDivisibleByFive(): void
    {
        $result = $this->fizzBuzz->process(new Number(5));
        $this->assertEquals('Buzz', $result->getOutput());
    }
    
    public function testProcessNumberReturnsBazzForNumberDivisibleBySeven(): void
    {
        $result = $this->fizzBuzz->process(new Number(7));
        $this->assertEquals('Bazz', $result->getOutput());
    }
    
    public function testProcessNumberReturnsFizzBuzzForNumberDivisibleByThreeAndFive(): void
    {
        $result = $this->fizzBuzz->process(new Number(15));
        $this->assertEquals('FizzBuzz', $result->getOutput());
    }
    
    public function testProcessNumberReturnsFizzBazzForNumberDivisibleByThreeAndSeven(): void
    {
        $result = $this->fizzBuzz->process(new Number(21));
        $this->assertEquals('FizzBazz', $result->getOutput());
    }
    
    public function testProcessNumberReturnsBuzzBazzForNumberDivisibleByFiveAndSeven(): void
    {
        $result = $this->fizzBuzz->process(new Number(35));
        $this->assertEquals('BuzzBazz', $result->getOutput());
    }
    
    public function testProcessNumberReturnsFizzBuzzBazzForNumberDivisibleByThreeFiveAndSeven(): void
    {
        $result = $this->fizzBuzz->process(new Number(105));
        $this->assertEquals('FizzBuzzBazz', $result->getOutput());
    }
    
    public function testProcessRangeReturnsArrayOfResults(): void
    {
        $results = $this->fizzBuzz->processRange(1, 15);
        $this->assertCount(15, $results);
        $this->assertEquals('1', $results[0]->getOutput());
        $this->assertEquals('2', $results[1]->getOutput());
        $this->assertEquals('Fizz', $results[2]->getOutput());
        $this->assertEquals('FizzBuzz', $results[14]->getOutput());
    }
    
    public function testProcessRangeThrowsExceptionForInvalidRange(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->fizzBuzz->processRange(15, 1);
    }
    
    public function testProcessRangeThrowsExceptionForNegativeStart(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->fizzBuzz->processRange(-1, 15);
    }
} 
