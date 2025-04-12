<?php

require_once __DIR__ . '/vendor/autoload.php';

use FizzBuzz\CLI;

// Run the CLI with the command line arguments
echo CLI::run($argv);
