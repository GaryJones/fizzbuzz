#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use FizzBuzz\CLI\CLIApplication;
use FizzBuzz\CLI\InputValidator;
use FizzBuzz\Config\RuleConfig;
use FizzBuzz\FizzBuzz;
use FizzBuzz\Formatter\FormatterFactory;

$config = new RuleConfig();
$fizzBuzz = new FizzBuzz($config->getRules());
$validator = new InputValidator();
$formatterFactory = new FormatterFactory();

$app = new CLIApplication($fizzBuzz, $validator);
echo $app->run($argv);
