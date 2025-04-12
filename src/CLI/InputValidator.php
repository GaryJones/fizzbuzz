<?php

namespace FizzBuzz\CLI;

use FizzBuzz\Exception\InvalidFormatException;
use FizzBuzz\Exception\InvalidInputException;

class InputValidator
{
    private const VALID_FORMATS = ['text', 'json', 'csv'];

    /**
     * Validate the input options
     *
     * @param array $options The options to validate
     * @throws InvalidInputException If the input is invalid
     * @throws InvalidFormatException If the format is invalid
     */
    public function validate(array $options): void
    {
        if (isset($options['max']) && $options['max'] < 1) {
            throw new InvalidInputException('Maximum number must be greater than 0');
        }

        if (isset($options['start']) && $options['start'] < 1) {
            throw new InvalidInputException('Start number must be greater than 0');
        }

        if (isset($options['start'], $options['max']) && $options['start'] > $options['max']) {
            throw new InvalidInputException('Start number cannot be greater than maximum number');
        }

        if (isset($options['format']) && !in_array($options['format'], self::VALID_FORMATS)) {
            throw new InvalidFormatException(
                sprintf('Invalid format. Must be one of: %s', implode(', ', self::VALID_FORMATS))
            );
        }
    }
}
