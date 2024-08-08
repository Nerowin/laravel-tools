<?php

namespace Nerow\Tools\Extends;

use Illuminate\Validation\Rule as Origin;
use Illuminate\Validation\Rules\In;

class Rule extends Origin
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
