<?php

namespace Tests\CLI;

use FizzBuzz\CLI\CLIApplication;
use FizzBuzz\CLI\ValidatorInterface;
use FizzBuzz\Exception\InvalidInputException;
use FizzBuzz\FizzBuzz;
use FizzBuzz\Formatter\FormatterFactory;
use FizzBuzz\Formatter\FormatterInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CLIApplicationTest extends TestCase
{
    private CLIApplication $app;
    private FizzBuzz&MockObject $fizzBuzz;
    private ValidatorInterface&MockObject $validator;
    private FormatterInterface&MockObject $formatter;
    private FormatterFactory&MockObject $formatterFactory;

    protected function setUp(): void
    {
        $this->fizzBuzz = $this->createMock(FizzBuzz::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->formatter = $this->createMock(FormatterInterface::class);
        $this->formatterFactory = $this->createMock(FormatterFactory::class);

        $this->app = new CLIApplication($this->fizzBuzz, $this->validator, $this->formatterFactory);
    }

    public function testShowsHelpMessage(): void
    {
        $argv = ['fizzbuzz.php', '-h'];
        $output = $this->app->run($argv);
        $this->assertStringContainsString('FizzBuzz CLI', $output);
        $this->assertStringContainsString('Usage:', $output);
        $this->assertStringContainsString('Options:', $output);
    }

    public function testProcessesValidInput(): void
    {
        $argv = ['fizzbuzz.php', '-n', '20'];
        $expectedResults = ['1', '2', 'Fizz', '4', 'Buzz'];
        $expectedOutput = "1\n2\nFizz\n4\nBuzz";

        $this->validator->expects($this->once())
            ->method('validate')
            ->with([
                'max' => 20,
                'start' => 1,
                'format' => 'text'
            ]);

        $this->fizzBuzz->expects($this->once())
            ->method('processRange')
            ->with(1, 20)
            ->willReturn($expectedResults);

        $this->formatter->expects($this->once())
            ->method('format')
            ->with($expectedResults, 1)
            ->willReturn($expectedOutput);

        $this->formatterFactory->expects($this->once())
            ->method('create')
            ->with('text')
            ->willReturn($this->formatter);

        $output = $this->app->run($argv);
        $this->assertEquals($expectedOutput, $output);
    }

    public function testHandlesValidationError(): void
    {
        $argv = ['fizzbuzz.php', '-n', '0'];

        $this->validator->expects($this->once())
            ->method('validate')
            ->willThrowException(new InvalidInputException('Invalid input'));

        $output = $this->app->run($argv);
        $this->assertStringContainsString('Error:', $output);
        $this->assertStringContainsString('Invalid input', $output);
    }

    public function testHandlesLongOptions(): void
    {
        $argv = ['fizzbuzz.php', '--max', '20', '--start', '5', '--format', 'json'];
        $expectedResults = ['Buzz', 'Fizz', '7', '8', 'Fizz', 'Buzz'];
        $expectedOutput = '["Buzz","Fizz","7","8","Fizz","Buzz"]';

        $this->validator->expects($this->once())
            ->method('validate')
            ->with([
                'max' => 20,
                'start' => 5,
                'format' => 'json'
            ]);

        $this->fizzBuzz->expects($this->once())
            ->method('processRange')
            ->with(5, 20)
            ->willReturn($expectedResults);

        $this->formatter->expects($this->once())
            ->method('format')
            ->with($expectedResults, 5)
            ->willReturn($expectedOutput);

        $this->formatterFactory->expects($this->once())
            ->method('create')
            ->with('json')
            ->willReturn($this->formatter);

        $output = $this->app->run($argv);
        $this->assertEquals($expectedOutput, $output);
    }

    public function testHandlesMixedOptions(): void
    {
        $argv = ['fizzbuzz.php', '-n', '20', '--start', '5', '-f', 'csv'];
        $expectedResults = ['Buzz', 'Fizz', '7', '8', 'Fizz', 'Buzz'];
        $expectedOutput = "Buzz,Fizz,7,8,Fizz,Buzz";

        $this->validator->expects($this->once())
            ->method('validate')
            ->with([
                'max' => 20,
                'start' => 5,
                'format' => 'csv'
            ]);

        $this->fizzBuzz->expects($this->once())
            ->method('processRange')
            ->with(5, 20)
            ->willReturn($expectedResults);

        $this->formatter->expects($this->once())
            ->method('format')
            ->with($expectedResults, 5)
            ->willReturn($expectedOutput);

        $this->formatterFactory->expects($this->once())
            ->method('create')
            ->with('csv')
            ->willReturn($this->formatter);

        $output = $this->app->run($argv);
        $this->assertEquals($expectedOutput, $output);
    }
}
