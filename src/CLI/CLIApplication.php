<?php

namespace FizzBuzz\CLI;

use FizzBuzz\Exception\InvalidInputException;
use FizzBuzz\FizzBuzz;
use FizzBuzz\Formatter\FormatterFactory;
use FizzBuzz\Formatter\FormatterInterface;

class CLIApplication
{
    private FizzBuzz $fizzBuzz;
    private ValidatorInterface $validator;
    private FormatterFactory $formatterFactory;

    public function __construct(FizzBuzz $fizzBuzz, ValidatorInterface $validator, FormatterFactory $formatterFactory)
    {
        $this->fizzBuzz = $fizzBuzz;
        $this->validator = $validator;
        $this->formatterFactory = $formatterFactory;
    }

    /**
     * Run the CLI application
     *
     * @param array $argv Command line arguments
     * @return string The formatted output
     */
    public function run(array $argv): string
    {
        try {
            $options = $this->parseOptions($argv);

            // Handle help request first
            if ($options['help']) {
                return $this->getHelpMessage();
            }

            // Convert options to a standardized format
            $params = [
                'max' => $options['max'],
                'start' => $options['start'],
                'format' => $options['format']
            ];

            // Validate the parameters
            $this->validator->validate($params);

            // Process FizzBuzz
            $results = $this->fizzBuzz->processRange($params['start'], $params['max']);

            // Format output
            $formatter = $this->formatterFactory->create($params['format']);
            return $formatter->format($results, $params['start']);
        } catch (InvalidInputException $e) {
            return sprintf("Error: %s\n", $e->getMessage());
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
        // Initialize default values
        $options = [
            'help' => false,
            'max' => null,
            'start' => 1,
            'format' => 'text'
        ];

        // Skip the script name
        array_shift($argv);

        // Parse arguments
        for ($i = 0; $i < count($argv); $i++) {
            $arg = $argv[$i];

            switch ($arg) {
                case '-h':
                case '--help':
                    $options['help'] = true;
                    break;

                case '-n':
                case '--max':
                    if (isset($argv[$i + 1])) {
                        $options['max'] = (int)$argv[++$i];
                    }
                    break;

                case '-s':
                case '--start':
                    if (isset($argv[$i + 1])) {
                        $options['start'] = (int)$argv[++$i];
                    }
                    break;

                case '-f':
                case '--format':
                    if (isset($argv[$i + 1])) {
                        $options['format'] = $argv[++$i];
                    }
                    break;
            }
        }

        return $options;
    }

    /**
     * Show help message
     *
     * @return string Help message
     */
    private function getHelpMessage(): string
    {
        return <<<HELP
FizzBuzz CLI

Usage: fizzbuzz.php [options]

Options:
  -n, --max NUMBER    Maximum number to process (required)
  -s, --start NUMBER  Starting number (default: 1)
  -f, --format FORMAT Output format (text|json|csv, default: text)
  -h, --help         Show this help message

HELP;
    }
}
