<?php

namespace FizzBuzz\Tests\Formatter;

use FizzBuzz\Formatter\JsonFormatter;
use PHPUnit\Framework\TestCase;

class JsonFormatterTest extends TestCase
{
    private JsonFormatter $formatter;
    
    protected function setUp(): void
    {
        $this->formatter = new JsonFormatter();
    }
    
    /**
     * Test that format returns valid JSON
     */
    public function testFormatReturnsValidJson(): void
    {
        $results = ['1', '2', 'Fizz', '4', 'Buzz'];
        $startNumber = 1;
        
        $output = $this->formatter->format($results, $startNumber);
        
        $this->assertJson($output);
    }
    
    /**
     * Test that format includes correct structure
     */
    public function testFormatIncludesCorrectStructure(): void
    {
        $results = ['1', '2', 'Fizz', '4', 'Buzz'];
        $startNumber = 1;
        
        $output = $this->formatter->format($results, $startNumber);
        $decoded = json_decode($output, true);
        
        $this->assertIsArray($decoded);
        $this->assertCount(5, $decoded);
        
        // Check first item
        $this->assertEquals(1, $decoded[0]['number']);
        $this->assertEquals('1', $decoded[0]['result']);
        
        // Check Fizz
        $this->assertEquals(3, $decoded[2]['number']);
        $this->assertEquals('Fizz', $decoded[2]['result']);
        
        // Check Buzz
        $this->assertEquals(5, $decoded[4]['number']);
        $this->assertEquals('Buzz', $decoded[4]['result']);
    }
    
    /**
     * Test that format handles different start numbers
     */
    public function testFormatHandlesDifferentStartNumbers(): void
    {
        $results = ['Fizz', '4', 'Buzz'];
        $startNumber = 3;
        
        $output = $this->formatter->format($results, $startNumber);
        $decoded = json_decode($output, true);
        
        $this->assertEquals(3, $decoded[0]['number']);
        $this->assertEquals('Fizz', $decoded[0]['result']);
        $this->assertEquals(5, $decoded[2]['number']);
        $this->assertEquals('Buzz', $decoded[2]['result']);
    }
} 
