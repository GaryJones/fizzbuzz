<?php

namespace FizzBuzz\Tests\Rules;

use FizzBuzz\Rules\FizzRule;
use PHPUnit\Framework\TestCase;

class FizzRuleTest extends TestCase
{
    private FizzRule $rule;

    protected function setUp(): void
    {
        $this->rule = new FizzRule();
    }

    /**
     * @dataProvider provideNumbers
     */
    public function testMatches(int $number, bool $expected): void
    {
        $this->assertEquals($expected, $this->rule->matches($number));
    }

    public function testGetOutput(): void
    {
        $this->assertEquals('Fizz', $this->rule->getOutput());
    }

    /**
     * Test that the rule has the correct default priority
     */
    public function testGetPriority(): void
    {
        $this->assertEquals(1, $this->rule->getPriority());
    }

    /**
     * Test that the rule has the correct default configuration
     */
    public function testGetConfig(): void
    {
        $config = $this->rule->getConfig();

        $this->assertEquals(3, $config['divisor']);
        $this->assertEquals('Fizz', $config['output']);
    }

    /**
     * Test that the rule can be configured with custom values
     */
    public function testCustomConfiguration(): void
    {
        $rule = new FizzRule(6, 'Custom', 5);
        $config = $rule->getConfig();

        $this->assertEquals(6, $config['divisor']);
        $this->assertEquals('Custom', $config['output']);
        $this->assertEquals(5, $rule->getPriority());
    }

    public function provideNumbers(): array
    {
        return [
            'divisible by 3' => [3, true],
            'divisible by 3' => [6, true],
            'divisible by 3' => [9, true],
            'not divisible by 3' => [1, false],
            'not divisible by 3' => [2, false],
            'not divisible by 3' => [4, false],
            'not divisible by 3' => [5, false],
            'not divisible by 3' => [7, false],
            'not divisible by 3' => [8, false],
        ];
    }
}
