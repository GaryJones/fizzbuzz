<?php

namespace FizzBuzz\Tests\CLI;

use FizzBuzz\CLI\CLIApplication;
use FizzBuzz\CLI\InputValidator;
use FizzBuzz\Exception\InvalidInputException;
use FizzBuzz\FizzBuzz;
use FizzBuzz\Formatter\FormatterInterface;
use FizzBuzz\Value\Number;
use FizzBuzz\Value\Result;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CLIApplicationTest extends TestCase
{
    private FizzBuzz&MockObject $fizzBuzz;
    private InputValidator&MockObject $validator;
    private CLIApplication $app;

    protected function setUp(): void
    {
        $this->fizzBuzz = $this->createMock(FizzBuzz::class);
        $this->validator = $this->createMock(InputValidator::class);
        $this->app = new CLIApplication($this->fizzBuzz, $this->validator);
    }

    public function testShowsHelpMessage(): void
    {
        $output = $this->app->run(['fizzbuzz.php', '--help']);

        $this->assertStringContainsString('FizzBuzz CLI', $output);
        $this->assertStringContainsString('Usage:', $output);
        $this->assertStringContainsString('Options:', $output);
    }

    public function testProcessesValidInput(): void
    {
        $results = [new Result(new Number(1), '1')];
        $formatter = $this->createMock(FormatterInterface::class);

        $this->validator->expects($this->once())
            ->method('validate')
            ->with(['max' => 20]);

        $this->fizzBuzz->expects($this->once())
            ->method('processRange')
            ->with(1, 20)
            ->willReturn($results);

        $output = $this->app->run(['fizzbuzz.php', '--max', '20']);

        $this->assertNotEmpty($output);
    }

    public function testHandlesValidationError(): void
    {
        $this->validator->expects($this->once())
            ->method('validate')
            ->willThrowException(new InvalidInputException('Invalid input'));

        $output = $this->app->run(['fizzbuzz.php', '--max', '0']);

        $this->assertEquals("Error: Invalid input\n", $output);
    }
}
