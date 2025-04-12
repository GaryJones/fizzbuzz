<?php

namespace FizzBuzz\Formatter;

class JsonFormatter implements FormatterInterface
{
    /**
     * Format the results as JSON
     *
     * @param array $results Array of results to format
     * @param int $startNumber The starting number
     * @return string JSON formatted string
     */
    public function format(array $results, int $startNumber): string
    {
        $jsonOutput = [];
        for ($i = $startNumber; $i < $startNumber + count($results); $i++) {
            $jsonOutput[] = [
                'number' => $i,
                'result' => $results[$i - $startNumber]
            ];
        }
        
        return json_encode($jsonOutput, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
} 
