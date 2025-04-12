<?php

namespace FizzBuzz\Tests\Rules;

use FizzBuzz\Rules\BazzRule;
use PHPUnit\Framework\TestCase;

class BazzRuleTest extends TestCase
{
    private BazzRule $rule;

    protected function setUp(): void
    {
        $this->rule = new BazzRule();
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
        $this->assertEquals('Bazz', $this->rule->getOutput());
    }

    public function provideNumbers(): array
    {
        return [
            'divisible by 7' => [7, true],
            'divisible by 7' => [14, true],
            'divisible by 7' => [21, true],
            'not divisible by 7' => [1, false],
            'not divisible by 7' => [2, false],
            'not divisible by 7' => [3, false],
            'not divisible by 7' => [4, false],
            'not divisible by 7' => [5, false],
            'not divisible by 7' => [6, false],
            'not divisible by 7' => [8, false],
            'not divisible by 7' => [9, false],
            'not divisible by 7' => [10, false],
        ];
    }
} 
