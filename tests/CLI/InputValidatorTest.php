<?php

namespace FizzBuzz\Tests\CLI;

use FizzBuzz\CLI\InputValidator;
use FizzBuzz\Exception\InvalidFormatException;
use FizzBuzz\Exception\InvalidInputException;
use PHPUnit\Framework\TestCase;

class InputValidatorTest extends TestCase
{
    private InputValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new InputValidator();
    }

    public function testValidatesValidInput(): void
    {
        $this->validator->validate(['max' => 10]);
        $this->validator->validate(['max' => 10, 'start' => 1]);
        $this->validator->validate(['max' => 10, 'format' => 'json']);
        $this->validator->validate(['max' => 10, 'start' => 1, 'format' => 'text']);

        $this->assertTrue(true); // If we got here, no exceptions were thrown
    }

    public function testThrowsExceptionForInvalidMaxNumber(): void
    {
        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage('Maximum number must be greater than 0');

        $this->validator->validate(['max' => 0]);
    }

    public function testThrowsExceptionForInvalidStartNumber(): void
    {
        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage('Start number must be greater than 0');

        $this->validator->validate(['max' => 10, 'start' => 0]);
    }

    public function testThrowsExceptionWhenStartGreaterThanMax(): void
    {
        $this->expectException(InvalidInputException::class);
        $this->expectExceptionMessage('Start number cannot be greater than maximum number');

        $this->validator->validate(['max' => 5, 'start' => 10]);
    }

    public function testThrowsExceptionForInvalidFormat(): void
    {
        $this->expectException(InvalidFormatException::class);
        $this->expectExceptionMessage('Invalid format. Must be one of: text, json, csv');

        $this->validator->validate(['max' => 10, 'format' => 'invalid']);
    }
}
