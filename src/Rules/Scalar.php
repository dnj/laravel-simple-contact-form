<?php

namespace dnj\SimpleContactForm\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class Scalar implements InvokableRule
{
    public function __invoke($attribute, $value, $fail)
    {
        if (!is_scalar($value)) {
            $fail('The :attribute must be scalar.');
        }
    }
}
