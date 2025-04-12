<?php

namespace FizzBuzz\Config;

use FizzBuzz\Rules\BazzRule;
use FizzBuzz\Rules\BuzzRule;
use FizzBuzz\Rules\FizzRule;
use FizzBuzz\Rules\Rule;

class RuleConfig
{
    /** @var Rule[] */
    private array $rules;

    /**
     * @param Rule[]|null $rules Optional custom rules
     */
    public function __construct(?array $rules = null)
    {
        $this->rules = $rules ?? [
            new FizzRule(),
            new BuzzRule(),
            new BazzRule()
        ];
    }

    /**
     * Get the configured rules
     *
     * @return Rule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }
}
