<?php

namespace FizzBuzz\Rules;

abstract class AbstractRule implements Rule
{
    public function __construct(
        private readonly int $divisor,
        private readonly string $output,
        private readonly int $priority
    ) {}

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getConfig(): array
    {
        return [
            'divisor' => $this->divisor,
            'output' => $this->output,
            'priority' => $this->priority,
        ];
    }

    public function matches(int $number): bool
    {
        return match(true) {
            $number % $this->divisor === 0 => true,
            default => false,
        };
    }

    public function getOutput(): string
    {
        return $this->output;
    }

    public static function create(array $config): static
    {
        return new static(
            divisor: $config['divisor'],
            output: $config['output'],
            priority: $config['priority'] ?? 1
        );
    }
} 
