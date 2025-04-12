<?php

namespace FizzBuzz\Tests;

use FizzBuzz\CLI\CLIApplication;
use FizzBuzz\CLI\InputValidator;
use FizzBuzz\Config\RuleConfig;
use FizzBuzz\FizzBuzz;
use FizzBuzz\Formatter\FormatterFactory;
use PHPUnit\Framework\TestCase;

class CLITest extends TestCase
{
    private CLIApplication $app;

    protected function setUp(): void
    {
        $config = new RuleConfig();
        $fizzBuzz = new FizzBuzz($config->getRules());
        $validator = new InputValidator();
        $formatterFactory = new FormatterFactory();

        $this->app = new CLIApplication($fizzBuzz, $validator, $formatterFactory);
    }

    /**
     * Test that the help message is displayed when requested
     */
    public function testHelpMessage(): void
    {
        $output = $this->app->run(['fizzbuzz.php', '-h']);

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
        $output = $this->app->run(['fizzbuzz.php', '-n', '0']);
        $this->assertStringContainsString('Error:', $output);
        $this->assertStringContainsString('Maximum number must be greater than 0', $output);

        $output = $this->app->run(['fizzbuzz.php', '-n', '10', '-s', '0']);
        $this->assertStringContainsString('Error:', $output);
        $this->assertStringContainsString('Start number must be greater than 0', $output);

        $output = $this->app->run(['fizzbuzz.php', '-n', '5', '-s', '10']);
        $this->assertStringContainsString('Error:', $output);
        $this->assertStringContainsString('Start number cannot be greater than maximum number', $output);
    }

    /**
     * Test that the script handles different output formats correctly
     */
    public function testOutputFormats(): void
    {
        // Test JSON format
        $output = $this->app->run(['fizzbuzz.php', '-n', '5', '-f', 'json']);
        $json = json_decode($output, true);
        $this->assertIsArray($json);
        $this->assertCount(5, $json);
        $this->assertArrayHasKey('number', $json[0]);
        $this->assertArrayHasKey('result', $json[0]);

        // Test CSV format
        $output = $this->app->run(['fizzbuzz.php', '-n', '5', '-f', 'csv']);
        $this->assertStringContainsString(',', $output);
        $this->assertStringContainsString('1,2,Fizz,4,Buzz', $output);

        // Test text format (default)
        $output = $this->app->run(['fizzbuzz.php', '-n', '5']);
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
        $output = $this->app->run(['fizzbuzz.php', '-n', '5', '-s', '1', '-f', 'text']);
        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('2', $output);
        $this->assertStringContainsString('Fizz', $output);
        $this->assertStringContainsString('4', $output);
        $this->assertStringContainsString('Buzz', $output);

        // Test long options
        $output = $this->app->run(['fizzbuzz.php', '--max', '5', '--start', '1', '--format', 'text']);
        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('2', $output);
        $this->assertStringContainsString('Fizz', $output);
        $this->assertStringContainsString('4', $output);
        $this->assertStringContainsString('Buzz', $output);

        // Test mixed options
        $output = $this->app->run(['fizzbuzz.php', '-n', '5', '--start', '1', '--format', 'text']);
        $this->assertStringContainsString('1', $output);
        $this->assertStringContainsString('2', $output);
        $this->assertStringContainsString('Fizz', $output);
        $this->assertStringContainsString('4', $output);
        $this->assertStringContainsString('Buzz', $output);
    }
}
