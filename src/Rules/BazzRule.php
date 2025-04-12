<?php

namespace FizzBuzz\Rules;

class BazzRule extends AbstractRule
{
    public function __construct(
        int $divisor = 7,
        string $output = 'Bazz',
        int $priority = 3
    ) {
        parent::__construct($divisor, $output, $priority);
    }
} 
