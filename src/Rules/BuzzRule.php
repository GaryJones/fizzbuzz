<?php

namespace FizzBuzz\Rules;

class BuzzRule extends AbstractRule
{
    public function __construct(
        int $divisor = 5,
        string $output = 'Buzz',
        int $priority = 2
    ) {
        parent::__construct($divisor, $output, $priority);
    }
} 
