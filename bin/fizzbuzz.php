#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use FizzBuzz\CLI\CLIApplication;
use FizzBuzz\Container\Container;

try {
    $container = new Container();
    $app = $container->get(CLIApplication::class);
    echo $app->run($argv);
} catch (\Exception $e) {
    fwrite(STDERR, sprintf("Error: %s\n", $e->getMessage()));
    exit(1);
}
