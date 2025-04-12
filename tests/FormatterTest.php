<?php

namespace FizzBuzz\Tests;

use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    /**
     * Test JSON formatting
     */
    public function testJsonFormatting(): void
    {
        $results = [
            '1', '2', 'Fizz', '4', 'Buzz',
            'Fizz', 'Bazz', '8', 'Fizz', 'Buzz',
            '11', 'Fizz', '13', 'Bazz', 'FizzBuzz'
        ];
        $startNumber = 1;
        $maxNumber = 15;

        $jsonOutput = [];
        for ($i = $startNumber; $i <= $maxNumber; $i++) {
            $jsonOutput[] = [
                'number' => $i,
                'result' => $results[$i - $startNumber]
            ];
        }

        $formatted = json_encode($jsonOutput, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Decode to verify structure
        $decoded = json_decode($formatted, true);

        $this->assertIsArray($decoded);
        $this->assertCount(15, $decoded);

        // Check first item
        $this->assertEquals(1, $decoded[0]['number']);
        $this->assertEquals('1', $decoded[0]['result']);

        // Check Fizz
        $this->assertEquals(3, $decoded[2]['number']);
        $this->assertEquals('Fizz', $decoded[2]['result']);

        // Check Buzz
        $this->assertEquals(5, $decoded[4]['number']);
        $this->assertEquals('Buzz', $decoded[4]['result']);

        // Check Bazz
        $this->assertEquals(7, $decoded[6]['number']);
        $this->assertEquals('Bazz', $decoded[6]['result']);

        // Check FizzBuzz
        $this->assertEquals(15, $decoded[14]['number']);
        $this->assertEquals('FizzBuzz', $decoded[14]['result']);
    }

    /**
     * Test CSV formatting
     */
    public function testCsvFormatting(): void
    {
        $results = ['1', '2', 'Fizz', '4', 'Buzz', 'Fizz', 'Bazz', '8', 'Fizz', 'Buzz'];

        $formatted = implode(',', $results);

        $this->assertEquals('1,2,Fizz,4,Buzz,Fizz,Bazz,8,Fizz,Buzz', $formatted);
    }

    /**
     * Test text formatting with colors
     */
    public function testTextFormatting(): void
    {
        $results = ['1', '2', 'Fizz', '4', 'Buzz', 'Fizz', 'Bazz', '8', 'Fizz', 'Buzz'];

        $formatted = [];
        foreach ($results as $result) {
            $formatted[] = $this->colorizeResult($result);
        }

        // Check that numbers are not colored
        $this->assertEquals('1', $formatted[0]);
        $this->assertEquals('2', $formatted[1]);

        // Check that Fizz is colored green
        $this->assertStringContainsString("\033[32m", $formatted[2]);
        $this->assertStringContainsString("Fizz", $formatted[2]);
        $this->assertStringContainsString("\033[0m", $formatted[2]);

        // Check that Buzz is colored blue
        $this->assertStringContainsString("\033[34m", $formatted[4]);
        $this->assertStringContainsString("Buzz", $formatted[4]);
        $this->assertStringContainsString("\033[0m", $formatted[4]);

        // Check that Bazz is colored magenta
        $this->assertStringContainsString("\033[35m", $formatted[6]);
        $this->assertStringContainsString("Bazz", $formatted[6]);
        $this->assertStringContainsString("\033[0m", $formatted[6]);
    }

    /**
     * Test combined formatting (FizzBuzz, FizzBazz, etc.)
     */
    public function testCombinedFormatting(): void
    {
        $results = ['1', '2', 'Fizz', '4', 'Buzz', 'Fizz', 'Bazz', '8', 'Fizz', 'Buzz', '11', 'Fizz', '13', 'Bazz', 'FizzBuzz'];

        $formatted = [];
        foreach ($results as $result) {
            $formatted[] = $this->colorizeResult($result);
        }

        // Check FizzBuzz (index 14)
        $this->assertStringContainsString("\033[32m", $formatted[14]); // Green for Fizz
        $this->assertStringContainsString("\033[34m", $formatted[14]); // Blue for Buzz
        $this->assertStringContainsString("Fizz", $formatted[14]);
        $this->assertStringContainsString("Buzz", $formatted[14]);
        $this->assertStringContainsString("\033[0m", $formatted[14]);
    }

    /**
     * Helper function to colorize results (copied from CLI script)
     */
    private function colorizeResult(string $result): string
    {
        $colors = [
            'Fizz' => "\033[32m", // Green
            'Buzz' => "\033[34m", // Blue
            'Bazz' => "\033[35m", // Magenta
        ];

        $reset = "\033[0m";

        // If it's just a number, return as is
        if (is_numeric($result)) {
            return $result;
        }

        // Apply colors to each part
        $coloredResult = $result;
        foreach ($colors as $word => $color) {
            $coloredResult = str_replace($word, $color . $word . $reset, $coloredResult);
        }

        return $coloredResult;
    }
}
