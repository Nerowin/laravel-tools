<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Json implements CastsAttributes
{
    /**
     * Décode un tableau JSON.
     */
    public function get(Model $model, string $key, ?string $value, array $attributes): array
    {
        return ! empty($value) ? json_decode($value, true) : [];
    }

    /**
     * Encode un array en JSON.
     */
    public function set(Model $model, string $key, ?array $value, array $attributes): ?string
    {
        return ! empty($value)
             ? json_encode($value, JSON_UNESCAPED_UNICODE)
             : null;
    }
}
