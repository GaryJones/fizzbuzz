<?php

namespace Tests\Container;

use FizzBuzz\CLI\CLIApplication;
use FizzBuzz\CLI\ValidatorInterface;
use FizzBuzz\Container\Container;
use FizzBuzz\FizzBuzz;
use FizzBuzz\Formatter\FormatterFactory;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    private Container $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    public function testContainerInstantiatesCLIApplication(): void
    {
        $app = $this->container->get(CLIApplication::class);

        $this->assertInstanceOf(CLIApplication::class, $app);

        // Use reflection to verify all dependencies are properly injected
        $reflection = new \ReflectionClass($app);

        $fizzBuzzProp = $reflection->getProperty('fizzBuzz');
        $fizzBuzzProp->setAccessible(true);
        $this->assertInstanceOf(FizzBuzz::class, $fizzBuzzProp->getValue($app));

        $validatorProp = $reflection->getProperty('validator');
        $validatorProp->setAccessible(true);
        $this->assertInstanceOf(ValidatorInterface::class, $validatorProp->getValue($app));

        $formatterFactoryProp = $reflection->getProperty('formatterFactory');
        $formatterFactoryProp->setAccessible(true);
        $this->assertInstanceOf(FormatterFactory::class, $formatterFactoryProp->getValue($app));
    }

    public function testContainerThrowsExceptionForUnknownService(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Service "UnknownService" not found.');

        $this->container->get('UnknownService');
    }
}
