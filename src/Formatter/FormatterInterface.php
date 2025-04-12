<?php

namespace FizzBuzz\Formatter;

use FizzBuzz\Value\Result;

interface FormatterInterface
{
    /**
     * Format the FizzBuzz results
     *
     * @param Result[] $results Array of FizzBuzz results
     * @param int $startNumber The starting number of the sequence
     * @return string The formatted output
     */
    public function format(array $results, int $startNumber): string;
}
