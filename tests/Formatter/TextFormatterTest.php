<?php

namespace FizzBuzz\Tests\Formatter;

use FizzBuzz\Formatter\TextFormatter;
use PHPUnit\Framework\TestCase;

class TextFormatterTest extends TestCase
{
    private TextFormatter $formatter;
    
    protected function setUp(): void
    {
        $this->formatter = new TextFormatter();
    }
    
    /**
     * Test that format returns newline-separated values
     */
    public function testFormatReturnsNewlineSeparatedValues(): void
    {
        $results = ['1', '2', 'Fizz', '4', 'Buzz'];
        $startNumber = 1;
        
        $output = $this->formatter->format($results, $startNumber);
        $lines = explode("\n", $output);
        
        $this->assertCount(5, $lines);
        $this->assertEquals('1', $lines[0]);
        $this->assertEquals('2', $lines[1]);
        $this->assertStringContainsString('Fizz', $lines[2]);
        $this->assertEquals('4', $lines[3]);
        $this->assertStringContainsString('Buzz', $lines[4]);
    }
    
    /**
     * Test that format handles empty results
     */
    public function testFormatHandlesEmptyResults(): void
    {
        $results = [];
        $startNumber = 1;
        
        $output = $this->formatter->format($results, $startNumber);
        
        $this->assertEquals('', $output);
    }
    
    /**
     * Test that format handles single result
     */
    public function testFormatHandlesSingleResult(): void
    {
        $results = ['Fizz'];
        $startNumber = 3;
        
        $output = $this->formatter->format($results, $startNumber);
        
        $this->assertStringContainsString('Fizz', $output);
        $this->assertStringContainsString("\033[32m", $output); // Green color
    }
    
    /**
     * Test that format colorizes Fizz, Buzz, and Bazz
     */
    public function testFormatColorizesKeywords(): void
    {
        $results = ['Fizz', 'Buzz', 'Bazz', 'FizzBuzz', 'FizzBazz'];
        $startNumber = 1;
        
        $output = $this->formatter->format($results, $startNumber);
        $lines = explode("\n", $output);
        
        // Check Fizz is green
        $this->assertStringContainsString("\033[32m", $lines[0]);
        $this->assertStringContainsString("Fizz", $lines[0]);
        $this->assertStringContainsString("\033[0m", $lines[0]);
        
        // Check Buzz is blue
        $this->assertStringContainsString("\033[34m", $lines[1]);
        $this->assertStringContainsString("Buzz", $lines[1]);
        $this->assertStringContainsString("\033[0m", $lines[1]);
        
        // Check Bazz is magenta
        $this->assertStringContainsString("\033[35m", $lines[2]);
        $this->assertStringContainsString("Bazz", $lines[2]);
        $this->assertStringContainsString("\033[0m", $lines[2]);
        
        // Check combined colors
        $this->assertStringContainsString("\033[32m", $lines[3]); // Green for Fizz
        $this->assertStringContainsString("\033[34m", $lines[3]); // Blue for Buzz
        $this->assertStringContainsString("Fizz", $lines[3]);
        $this->assertStringContainsString("Buzz", $lines[3]);
        $this->assertStringContainsString("\033[0m", $lines[3]);
    }
} 
