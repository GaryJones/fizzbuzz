<?php

namespace FizzBuzz\Tests\Value;

use FizzBuzz\Value\Number;
use FizzBuzz\Value\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    private Number $number;
    
    protected function setUp(): void
    {
        $this->number = new Number(15);
    }
    
    /**
     * Test that creating a result works
     */
    public function testCreateResult(): void
    {
        $result = new Result($this->number, 'FizzBuzz');
        
        $this->assertSame($this->number, $result->getNumber());
        $this->assertEquals('FizzBuzz', $result->getOutput());
    }
    
    /**
     * Test that contains works correctly
     */
    public function testContains(): void
    {
        $result = new Result($this->number, 'FizzBuzz');
        
        $this->assertTrue($result->contains('Fizz'));
        $this->assertTrue($result->contains('Buzz'));
        $this->assertFalse($result->contains('Bazz'));
    }
    
    /**
     * Test that toArray works correctly
     */
    public function testToArray(): void
    {
        $result = new Result($this->number, 'FizzBuzz');
        $array = $result->toArray();
        
        $this->assertEquals([
            'number' => 15,
            'result' => 'FizzBuzz'
        ], $array);
    }
    
    /**
     * Test that __toString works correctly
     */
    public function testToString(): void
    {
        $result = new Result($this->number, 'FizzBuzz');
        
        $this->assertEquals('FizzBuzz', (string) $result);
    }
} 
