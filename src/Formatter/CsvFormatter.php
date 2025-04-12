<?php

namespace FizzBuzz\Formatter;

class CsvFormatter implements FormatterInterface
{
    /**
     * Format the results as CSV
     *
     * @param array $results Array of results to format
     * @param int $startNumber The starting number (unused in CSV format)
     * @return string CSV formatted string
     */
    public function format(array $results, int $startNumber): string
    {
        return implode(',', $results);
    }
}
