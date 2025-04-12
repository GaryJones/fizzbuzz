<?php

namespace FizzBuzz;

use FizzBuzz\Formatter\FormatterFactory;
use FizzBuzz\Formatter\FormatterInterface;

class CLI
{
    /**
     * Run the CLI application
     *
     * @param array $argv Command line arguments
     * @return string The formatted output
     */
    public static function run(array $argv): string
    {
        $options = self::parseOptions($argv);
        
        if (isset($options['help'])) {
            return self::showHelp();
        }
        
        $maxNumber = $options['max'] ?? 100;
        $startNumber = $options['start'] ?? 1;
        $format = $options['format'] ?? 'text';
        
        // Validate input
        if ($maxNumber < 1) {
            return "Error: Maximum number must be greater than 0\n";
        }
        
        if ($startNumber < 1) {
            return "Error: Start number must be greater than 0\n";
        }
        
        if ($startNumber > $maxNumber) {
            return "Error: Start number cannot be greater than maximum number\n";
        }
        
        // Create FizzBuzz instance with rules
        $fizzBuzz = new FizzBuzz([
            new Rules\FizzRule(),
            new Rules\BuzzRule(),
            new Rules\BazzRule()
        ]);
        
        // Get results
        $results = $fizzBuzz->processRange($startNumber, $maxNumber);
        
        // Format output
        try {
            $formatter = FormatterFactory::create($format);
            return $formatter->format($results, $startNumber) . "\n";
        } catch (\InvalidArgumentException $e) {
            return "Error: " . $e->getMessage() . "\n";
        }
    }
    
    /**
     * Parse command line options
     *
     * @param array $argv Command line arguments
     * @return array Parsed options
     */
    private static function parseOptions(array $argv): array
    {
        $options = [];
        
        // Skip the script name
        array_shift($argv);
        
        for ($i = 0; $i < count($argv); $i++) {
            $arg = $argv[$i];
            
            if ($arg === '--help' || $arg === '-h') {
                $options['help'] = true;
            } elseif ($arg === '--max' || $arg === '-n') {
                $options['max'] = (int) $argv[++$i];
            } elseif ($arg === '--start' || $arg === '-s') {
                $options['start'] = (int) $argv[++$i];
            } elseif ($arg === '--format' || $arg === '-f') {
                $options['format'] = $argv[++$i];
            }
        }
        
        return $options;
    }
    
    /**
     * Show help message
     *
     * @return string Help message
     */
    private static function showHelp(): string
    {
        return <<<HELP
FizzBuzz CLI

Usage:
  php fizzbuzz.php [options]

Options:
  -n, --max NUMBER    Maximum number to process (default: 100)
  -s, --start NUMBER  Starting number (default: 1)
  -f, --format FORMAT Output format (json, csv, text) (default: text)
  -h, --help         Show this help message

Examples:
  php fizzbuzz.php --max 20
  php fizzbuzz.php -n 30 -f json
  php fizzbuzz.php --start 5 --max 15 --format csv
HELP;
    }
} 
