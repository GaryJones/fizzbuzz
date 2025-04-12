<?php

namespace FizzBuzz\Rules;

class FizzRule extends AbstractRule
{
    public function __construct(
        int $divisor = 3,
        string $output = 'Fizz',
        int $priority = 1
    ) {
        parent::__construct($divisor, $output, $priority);
    }
}
