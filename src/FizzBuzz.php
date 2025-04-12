<?php

namespace FizzBuzz;

use FizzBuzz\Rules\Rule;
use FizzBuzz\Value\Number;
use FizzBuzz\Value\Result;

class FizzBuzz
{
    /** @var Rule[] */
    private array $rules;

    /**
     * @param \FizzBuzz\Rules\Rule[] $rules
     */
    public function __construct(array $rules)
    {
        usort($rules, fn(\FizzBuzz\Rules\Rule $a, \FizzBuzz\Rules\Rule $b) => $a->getPriority() - $b->getPriority());
        $this->rules = $rules;
    }

    public function process(Number $number): Result
    {
        $output = '';
        foreach ($this->rules as $rule) {
            if ($rule->matches($number->getValue())) {
                $output .= $rule->getOutput();
            }
        }

        return new Result($number, $output ?: (string) $number->getValue());
    }

    /**
     * @return Result[]
     * @throws \InvalidArgumentException
     */
    public function processRange(int $start, int $end): array
    {
        if ($start <= 0) {
            throw new \InvalidArgumentException('Start number must be positive');
        }

        if ($end < $start) {
            throw new \InvalidArgumentException('End number must be greater than or equal to start number');
        }

        $results = [];
        for ($i = $start; $i <= $end; $i++) {
            $results[] = $this->process(new Number($i));
        }

        return $results;
    }

    /**
     * Sort rules by priority (lower priority first)
     *
     * @param \FizzBuzz\Rules\Rule[] $rules
     * @return \FizzBuzz\Rules\Rule[]
     */
    private function sortRulesByPriority(array $rules): array
    {
        usort($rules, function (\FizzBuzz\Rules\Rule $a, \FizzBuzz\Rules\Rule $b) {
            return $a->getPriority() - $b->getPriority();
        });
        return $rules;
    }

    /**
     * Validate rules
     *
     * @param \FizzBuzz\Rules\Rule[] $rules
     * @throws \InvalidArgumentException
     */
    private function validateRules(array $rules): void
    {
        foreach ($rules as $rule) {
            if (!($rule instanceof \FizzBuzz\Rules\Rule)) {
                throw new \InvalidArgumentException('All rules must implement the Rule interface');
            }
        }
    }
}
