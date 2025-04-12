# FizzBuzz

A modern PHP implementation of the classic FizzBuzz programming exercise, built with clean architecture principles and modern PHP 8.x features.

## Overview

This project implements the FizzBuzz problem with a clean, extensible architecture that allows for easy addition of new rules. It demonstrates modern PHP practices including:

- PHP 8.x features (readonly properties, constructor property promotion, match expressions)
- Clean architecture principles
- SOLID design principles
- Test-driven development
- PSR-12 coding standards

## Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/fizzbuzz.git
cd fizzbuzz

# Install dependencies
composer install
```

## Usage

### Command Line Interface

```bash
# Process a single number
php bin/fizzbuzz.php 15
# Output: FizzBuzz

# Process a range of numbers
php bin/fizzbuzz.php 1 15
# Output: 1, 2, Fizz, 4, Buzz, Fizz, 7, 8, Fizz, Buzz, 11, Fizz, 13, 14, FizzBuzz
```

### As a Library

```php
use FizzBuzz\FizzBuzz;
use FizzBuzz\Rules\FizzRule;
use FizzBuzz\Rules\BuzzRule;
use FizzBuzz\Rules\BazzRule;
use FizzBuzz\Value\Number;

// Create a FizzBuzz instance with default rules
$fizzBuzz = new FizzBuzz([
    new FizzRule(),
    new BuzzRule(),
    new BazzRule()
]);

// Process a single number
$result = $fizzBuzz->process(new Number(15));
echo $result->getOutput(); // Outputs: FizzBuzz

// Process a range of numbers
$results = $fizzBuzz->processRange(1, 15);
foreach ($results as $result) {
    echo $result->getOutput() . "\n";
}
```

## Architecture

The project follows a clean architecture approach with the following components:

### Core Components

- **Rules**: Each rule (Fizz, Buzz, Bazz) implements the `Rule` interface and extends `AbstractRule`
- **Values**: Value objects for Numbers and Results
- **FizzBuzz**: The main service that processes numbers using the rules

### Design Principles

1. **Single Responsibility Principle**: Each class has a single responsibility
2. **Open/Closed Principle**: New rules can be added without modifying existing code
3. **Liskov Substitution Principle**: Rules can be substituted with their subtypes
4. **Interface Segregation**: Clean, focused interfaces
5. **Dependency Inversion**: High-level modules depend on abstractions

### Modern PHP Features

- Readonly properties (PHP 8.1)
- Constructor property promotion (PHP 8.0)
- Match expressions (PHP 8.0)
- Named arguments (PHP 8.0)
- Union types in PHPDoc (PHP 8.0)

## Testing

```bash
# Run all tests
vendor/bin/phpunit

# Run tests with coverage
vendor/bin/phpunit --coverage-html coverage
```

## Development

### Adding a New Rule

1. Create a new class extending `AbstractRule`:

```php
namespace FizzBuzz\Rules;

class NewRule extends AbstractRule
{
    public function __construct(
        int $divisor = 11,
        string $output = 'New',
        int $priority = 4
    ) {
        parent::__construct($divisor, $output, $priority);
    }
}
```

2. Add the rule to your FizzBuzz instance:

```php
$fizzBuzz = new FizzBuzz([
    new FizzRule(),
    new BuzzRule(),
    new BazzRule(),
    new NewRule()
]);
```

## Project Structure

```
fizzbuzz/
├── bin/
│   └── fizzbuzz.php
├── src/
│   ├── FizzBuzz.php
│   ├── Rules/
│   │   ├── AbstractRule.php
│   │   ├── Rule.php
│   │   ├── FizzRule.php
│   │   ├── BuzzRule.php
│   │   └── BazzRule.php
│   └── Value/
│       ├── Number.php
│       └── Result.php
├── tests/
│   ├── FizzBuzzTest.php
│   └── Rules/
│       ├── FizzRuleTest.php
│       ├── BuzzRuleTest.php
│       └── BazzRuleTest.php
├── .editorconfig
├── .gitignore
├── composer.json
├── LICENSE
└── README.md
```

## Development Tools

- PHPUnit for testing
- EditorConfig for consistent coding style
- PSR-12 coding standards

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

This project was primarily developed using [Cursor](https://cursor.sh), an AI-powered IDE, with assistance from Claude 3.7 Sonnet. The architecture and implementation decisions were guided by modern PHP best practices and clean architecture principles.

## Contributing

Contributions are not desired at this time - it's test project.
