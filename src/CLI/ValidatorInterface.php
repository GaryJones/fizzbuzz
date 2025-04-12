<?php

namespace FizzBuzz\CLI;

interface ValidatorInterface
{
    /**
     * Validate the input parameters
     *
     * @param array $params The input parameters to validate
     * @throws \FizzBuzz\Exception\InvalidInputException If validation fails
     */
    public function validate(array $params): void;
}
