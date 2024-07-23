<?php

use Illuminate\Http\Request;

//'\App\Models\\' . str_replace(['\\', 'Service'], '', substr($this::class, strrpos($this::class, '\\')))
//substr($attribute, 0, strpos($attribute, '.'))

function isEnv(array|string $env): bool
{
    return is_string($env)
         ? env('APP_ENV') == $env
         : in_array(env('APP_ENV'), $env);
}

function getRequest(Request|array $request): Request
{
    return is_array($request) ? new Request($request) : $request;
}