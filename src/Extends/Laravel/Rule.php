<?php

namespace App\Extends\Laravel;

use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\Rules\In;

class Rule extends ValidationRule
{
    /**
     * Get an in constraint builder instance from a config array.
     */
    public static function inConfig(string $key): In
    {
        return self::in(config($key));
    }

    /**
     * Get an in constraint builder instance from a config array keys.
     */
    public static function inConfigKeys(string $key): In
    {
        return self::in(array_keys(config($key)));
    }
}
