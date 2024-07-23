<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Encryption implements CastsAttributes
{
    /**
     * Décrypte un string.
     */
    public function get(Model $model, string $key, ?string $value, array $attributes): ?string
    {
        return ! is_null($value) ? decrypt($value) : null;
    }

    /**
     * Encrypt un string.
     */
    public function set(Model $model, string $key, ?string $value, array $attributes): ?string
    {
        return ! is_null($value) ? encrypt($value) : null;
    }
}
