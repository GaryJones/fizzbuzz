<?php

namespace FizzBuzz\Value;

readonly class Result
{
    /**
     * Create a new Result value object
     *
     * @param Number $number The number that produced this result
     * @param string $output The result output (e.g., "Fizz", "Buzz", "1")
     */
    public function __construct(
        private Number $number,
        private string $output,
    ) {}
    
    /**
     * Get the number that produced this result
     *
     * @return Number The number
     */
    public function getNumber(): Number
    {
        return $this->number;
    }
    
    /**
     * Get the result output
     *
     * @return string The result output
     */
    public function getOutput(): string
    {
        return $this->output;
    }
    
    /**
     * Check if the result contains a specific word
     *
     * @param string $word The word to check for
     * @return bool True if the result contains the word
     */
    public function contains(string $word): bool
    {
        return str_contains($this->output, $word);
    }
    
    /**
     * Convert the result to an array representation
     *
     * @return array{number: int, result: string}
     */
    public function toArray(): array
    {
        return [
            'number' => $this->number->getValue(),
            'result' => $this->output
        ];
    }
    
    /**
     * Convert the result to a string
     *
     * @return string The result output
     */
    public function __toString(): string
    {
        return $this->output;
    }
} 
