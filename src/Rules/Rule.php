<?php

namespace FizzBuzz\Rules;

interface Rule
{
    /**
     * Get the priority of the rule
     * Higher priority rules are applied first
     * 
     * @return int A positive integer representing the rule's priority
     */
    public function getPriority(): int;
    
    /**
     * Get the configuration for this rule
     * 
     * @return array<string, int|string> An array with 'divisor' (positive integer) and 'output' (non-empty string) keys
     */
    public function getConfig(): array;
    
    /**
     * Check if the rule matches the given number
     * 
     * @param int $number The number to check
     * @return bool True if the rule matches, false otherwise
     */
    public function matches(int $number): bool;
    
    /**
     * Get the output for this rule
     * 
     * @return string A non-empty string
     */
    public function getOutput(): string;
    
    /**
     * Create a new rule with the given configuration
     * 
     * @param array{divisor: int, output: string, priority?: int} $config The rule configuration
     * @return static A new instance of the rule
     */
    public static function create(array $config): static;
} 
