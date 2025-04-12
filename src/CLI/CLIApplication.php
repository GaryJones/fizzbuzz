<?php

namespace FizzBuzz\CLI;

use FizzBuzz\Exception\FizzBuzzException;
use FizzBuzz\FizzBuzz;
use FizzBuzz\Formatter\FormatterFactory;
use FizzBuzz\Formatter\FormatterInterface;

class CLIApplication
{
    private FizzBuzz $fizzBuzz;
    private InputValidator $validator;

    public function __construct(
        FizzBuzz $fizzBuzz,
        InputValidator $validator
    ) {
        $this->fizzBuzz = $fizzBuzz;
        $this->validator = $validator;
    }

    /**
     * Run the CLI application
     *
     * @param array $argv Command line arguments
     * @return string The formatted output
     */
    public function run(array $argv): string
    {
        $options = $this->parseOptions($argv);

        if (isset($options['help'])) {
            return $this->showHelp();
        }

        try {
            $this->validator->validate($options);

            $maxNumber = $options['max'] ?? 100;
            $startNumber = $options['start'] ?? 1;
            $format = $options['format'] ?? 'text';

            $results = $this->fizzBuzz->processRange($startNumber, $maxNumber);
            $formatter = FormatterFactory::create($format);

            return $formatter->format($results, $startNumber) . "\n";
        } catch (FizzBuzzException $e) {
            return "Error: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Parse command line options
     *
     * @param array $argv Command line arguments
     * @return array Parsed options
     */
    private function parseOptions(array $argv): array
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
    private function showHelp(): string
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
