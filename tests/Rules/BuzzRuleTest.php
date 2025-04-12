<?php

namespace FizzBuzz\Tests\Rules;

use FizzBuzz\Rules\BuzzRule;
use PHPUnit\Framework\TestCase;

class BuzzRuleTest extends TestCase
{
    private BuzzRule $rule;

    protected function setUp(): void
    {
        $this->rule = new BuzzRule();
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
        $this->assertEquals('Buzz', $this->rule->getOutput());
    }

    public function provideNumbers(): array
    {
        return [
            'divisible by 5' => [5, true],
            'divisible by 5' => [10, true],
            'divisible by 5' => [15, true],
            'not divisible by 5' => [1, false],
            'not divisible by 5' => [2, false],
            'not divisible by 5' => [3, false],
            'not divisible by 5' => [4, false],
            'not divisible by 5' => [6, false],
            'not divisible by 5' => [7, false],
            'not divisible by 5' => [8, false],
            'not divisible by 5' => [9, false],
        ];
    }
}
