<?php

namespace FizzBuzz\Formatter;

class TextFormatter implements FormatterInterface
{
    private array $colors = [
        'Fizz' => "\033[32m", // Green
        'Buzz' => "\033[34m", // Blue
        'Bazz' => "\033[35m", // Magenta
    ];
    
    private string $reset = "\033[0m";
    
    /**
     * Format the results as colored text
     *
     * @param array $results Array of results to format
     * @param int $startNumber The starting number (unused in text format)
     * @return string Formatted text with colors
     */
    public function format(array $results, int $startNumber): string
    {
        $formatted = [];
        foreach ($results as $result) {
            $formatted[] = $this->colorizeResult($result);
        }
        
        return implode("\n", $formatted);
    }
    
    /**
     * Colorize a result string
     *
     * @param string $result The result to colorize
     * @return string The colorized result
     */
    private function colorizeResult(string $result): string
    {
        // If it's just a number, return as is
        if (is_numeric($result)) {
            return $result;
        }
        
        // Apply colors to each part
        $coloredResult = $result;
        foreach ($this->colors as $word => $color) {
            if (str_contains($result, $word)) {
                $coloredResult = str_replace($word, $color . $word . $this->reset, $coloredResult);
            }
        }
        
        return $coloredResult;
    }
} 
