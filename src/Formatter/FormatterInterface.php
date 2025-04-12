<?php

namespace FizzBuzz\Formatter;

interface FormatterInterface
{
    /**
     * Format the results array into the desired output format
     *
     * @param array $results Array of results to format
     * @param int $startNumber The starting number
     * @return string The formatted output
     */
    public function format(array $results, int $startNumber): string;
}
