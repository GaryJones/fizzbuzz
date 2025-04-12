<?php

namespace FizzBuzz\Value;

class Number
{
    private int $value;

    /**
     * Create a new Number value object
     *
     * @param int $value The number value
     * @throws \InvalidArgumentException If the number is less than 1
     */
    public function __construct(int $value)
    {
        if ($value < 1) {
            throw new \InvalidArgumentException('Number must be greater than 0');
        }

        $this->value = $value;
    }

    /**
     * Get the number value
     *
     * @return int The number value
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Check if the number is divisible by another number
     *
     * @param int $divisor The divisor to check
     * @return bool True if the number is divisible by the divisor
     */
    public function isDivisibleBy(int $divisor): bool
    {
        return $this->value % $divisor === 0;
    }

    /**
     * Create a range of numbers from start to end
     *
     * @param int $start The start number
     * @param int $end The end number
     * @return array Array of Number objects
     * @throws \InvalidArgumentException If start is greater than end
     */
    public static function range(int $start, int $end): array
    {
        if ($start > $end) {
            throw new \InvalidArgumentException('Start number cannot be greater than end number');
        }

        $numbers = [];
        for ($i = $start; $i <= $end; $i++) {
            $numbers[] = new self($i);
        }

        return $numbers;
    }
}
