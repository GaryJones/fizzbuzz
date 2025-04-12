<?php

namespace FizzBuzz\Container;

use FizzBuzz\CLI\CLIApplication;
use FizzBuzz\CLI\InputValidator;
use FizzBuzz\CLI\ValidatorInterface;
use FizzBuzz\Config\RuleConfig;
use FizzBuzz\FizzBuzz;
use FizzBuzz\Formatter\FormatterInterface;
use FizzBuzz\Formatter\FormatterFactory;

class Container
{
    private array $services = [];

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices(): void
    {
        // Register config
        $this->services[RuleConfig::class] = function () {
            return new RuleConfig();
        };

        // Register FizzBuzz with its dependencies
        $this->services[FizzBuzz::class] = function () {
            $config = $this->get(RuleConfig::class);
            return new FizzBuzz($config->getRules());
        };

        // Register validator
        $this->services[ValidatorInterface::class] = function () {
            return new InputValidator();
        };

        // Register formatter factory
        $this->services[FormatterFactory::class] = function () {
            return new FormatterFactory();
        };

        // Register main application
        $this->services[CLIApplication::class] = function () {
            return new CLIApplication(
                $this->get(FizzBuzz::class),
                $this->get(ValidatorInterface::class),
                $this->get(FormatterFactory::class)
            );
        };
    }

    public function get(string $id)
    {
        if (!isset($this->services[$id])) {
            throw new \RuntimeException(sprintf('Service "%s" not found.', $id));
        }

        $factory = $this->services[$id];
        return $factory();
    }
}
