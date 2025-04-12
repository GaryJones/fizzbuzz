<?php

namespace FizzBuzz\Tests\Formatter;

use FizzBuzz\Formatter\CsvFormatter;
use PHPUnit\Framework\TestCase;

class CsvFormatterTest extends TestCase
{
    private CsvFormatter $formatter;

    protected function setUp(): void
    {
        $this->formatter = new CsvFormatter();
    }

    /**
     * Test that format returns comma-separated values
     */
    public function testFormatReturnsCommaSeparatedValues(): void
    {
        $results = ['1', '2', 'Fizz', '4', 'Buzz'];
        $startNumber = 1;

        $output = $this->formatter->format($results, $startNumber);

        $this->assertEquals('1,2,Fizz,4,Buzz', $output);
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

        $this->assertEquals('Fizz', $output);
    }
}
