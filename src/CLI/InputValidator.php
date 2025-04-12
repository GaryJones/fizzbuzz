<?php

namespace FizzBuzz\CLI;

use FizzBuzz\Exception\InvalidFormatException;
use FizzBuzz\Exception\InvalidInputException;

class InputValidator implements ValidatorInterface
{
    private const VALID_FORMATS = ['text', 'json', 'csv'];

    public function validate(array $params): void
    {
        if (!isset($params['max']) || $params['max'] < 1) {
            throw new InvalidInputException('Maximum number must be greater than 0');
        }

        if (isset($params['start']) && $params['start'] < 1) {
            throw new InvalidInputException('Start number must be greater than 0');
        }

        if (isset($params['start'], $params['max']) && $params['start'] > $params['max']) {
            throw new InvalidInputException('Start number cannot be greater than maximum number');
        }

        if (isset($params['format']) && !in_array($params['format'], self::VALID_FORMATS)) {
            throw new InvalidFormatException(
                sprintf('Invalid format. Must be one of: %s', implode(', ', self::VALID_FORMATS))
            );
        }
    }
}
