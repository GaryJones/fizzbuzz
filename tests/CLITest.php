<?php

namespace FizzBuzz\Tests;

use FizzBuzz\CLI;
use PHPUnit\Framework\TestCase;

class CLITest extends TestCase
{
    /**
     * Test that the help message is displayed when requested
     */
    public function testHelpMessage(): void
    {
        $output = CLI::run(['fizzbuzz.php', '--help']);

        // Check that help message is displayed
        $this->assertStringContainsString('FizzBuzz CLI', $output);
        $this->assertStringContainsString('Usage:', $output);
        $this->assertStringContainsString('Options:', $output);
        $this->assertStringContainsString('-n, --max NUMBER', $output);
        $this->assertStringContainsString('-s, --start NUMBER', $output);
        $this->assertStringContainsString('-f, --format FORMAT', $output);
        $this->assertStringContainsString('-h, --help', $output);
    }

    /**
     * Test that the script handles invalid input correctly
     */
    public function testInvalidInput(): void
    {
        // Test invalid max number
        $output = CLI::run(['fizzbuzz.php', '-n', '0']);
        $this->assertStringContainsString('Error:', $output);

        // Test invalid start number
        $output = CLI::run(['fizzbuzz.php', '-s', '0']);
        $this->assertStringContainsString('Error:', $output);

        // Test start number greater than max number
        $output = CLI::run(['fizzbuzz.php', '-s', '10', '-n', '5']);
        $this->assertStringContainsString('Error:', $output);
    }

    /**
     * Test that the script handles different output formats correctly
     */
    public function testOutputFormats(): void
    {
        // Test JSON format
        $output = CLI::run(['fizzbuzz.php', '-n', '5', '-f', 'json']);

        // Verify JSON structure
        $json = json_decode($output, true);
        $this->assertIsArray($json);
        $this->assertCount(5, $json);
        $this->assertArrayHasKey('number', $json[0]);
        $this->assertArrayHasKey('result', $json[0]);

        // Test CSV format
        $output = CLI::run(['fizzbuzz.php', '-n', '5', '-f', 'csv']);

        // Verify CSV format
        $this->assertStringContainsString(',', $output);
        $this->assertStringContainsString('1,2,Fizz,4,Buzz', $output);

        // Test text format (default)
        $output = CLI::run(['fizzbuzz.php', '-n', '5']);

        // Verify text format with colors
        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('2', $output);
        $this->assertStringContainsString('Fizz', $output);
        $this->assertStringContainsString('4', $output);
        $this->assertStringContainsString('Buzz', $output);
    }

    /**
     * Test that the script handles different command line argument formats
     */
    public function testCommandLineFormats(): void
    {
        // Test short options
        $output = CLI::run(['fizzbuzz.php', '-n', '5', '-s', '1', '-f', 'text']);
        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('2', $output);
        $this->assertStringContainsString('Fizz', $output);
        $this->assertStringContainsString('4', $output);
        $this->assertStringContainsString('Buzz', $output);

        // Test long options
        $output = CLI::run(['fizzbuzz.php', '--max', '5', '--start', '1', '--format', 'text']);
        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('2', $output);
        $this->assertStringContainsString('Fizz', $output);
        $this->assertStringContainsString('4', $output);
        $this->assertStringContainsString('Buzz', $output);

        // Test mixed options
        $output = CLI::run(['fizzbuzz.php', '-n', '5', '--start', '1', '--format', 'text']);
        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('2', $output);
        $this->assertStringContainsString('Fizz', $output);
        $this->assertStringContainsString('4', $output);
        $this->assertStringContainsString('Buzz', $output);
    }
}
