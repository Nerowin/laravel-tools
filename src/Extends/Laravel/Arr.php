<?php

namespace App\Extends\Laravel;

use Illuminate\Support\Arr as Helper;

class Arr extends Helper
{
    /**
     * Implode les keys d'un tableau multidimensionnel à n profondeur.
     * Ex: [a => [b => 1]] donnera [a.b => 1]
     *
     * @param  array  $array
     * @return array
     */
    public static function implode_keys($array)
    {
        $res = [];

        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach (static::implode_keys($v) as $k2 => $v2) {
                    $res["$k.$k2"] = $v2;
                }
            } else {
                $res[$k] = $v;
            }
        }

        return $res;
    }

    /**
     * Execute une fonction de trim sur l'ensemble des éléments du tableau.
     *
     * @param  array  $array
     * @param  bool  $removeEmptyValues
     * @return array
     */
    public static function trim($array, $removeEmptyValues = true)
    {
        $array = array_map('trim', $array);

        return $removeEmptyValues ? array_filter($array) : $array;
    }

    /**
     * Array implode, ne prend pas en compte les valeurs null.
     *
     * @param  string  $separator
     * @param  array  $array
     * @return string
     */
    public static function implode($separator, $array)
    {
        return implode($separator, array_filter($array));
    }
}
