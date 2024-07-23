<?php

namespace App\Extends\Laravel;

use Illuminate\Support\Str as Helper;

class Str extends Helper
{
    /**
     * Retourne la ligne au numéro demandé.
     *
     * @param  string  $string
     * @param  int  $line
     * @return string|null
     */
    public static function line($string, $line)
    {
        return data_get(static::toArray($string), --$line);
    }

    /**
     * Vérifie si une ligne contient une regex.
     *
     * @param  string  $string
     * @param  int  $search
     * @return string|null
     */
    public static function lineContain($string, $search)
    {
        $array = static::toArray($string);

        $array = preg_grep("#.*($search).*#", $array);

        return end($array);
    }

    /**
     * Retourne le mot à la position cherché.
     *
     * @param  string  $string
     * @param  int  $number
     * @return string|null
     */
    public static function word($string, $number)
    {
        return data_get(explode(' ', static::squish($string)), --$number);
    }

    /**
     * Retourne le dernier mot.
     *
     * @param  string  $string
     * @return string|null
     */
    public static function lastWord($string)
    {
        $words = explode(' ', $string);

        return end($words);
    }

    /**
     * Formate un chemin.
     *
     * @param  string  $string
     * @return string|null
     */
    public static function path($string)
    {
        return preg_replace('#[\\\/]+#', '/', $string);
    }

    /**
     * Extension de la fonction basename.
     *
     * @param  string  $string
     * @return string|null
     */
    public static function basename($string)
    {
        $string = static::path($string);

        return static::afterLast($string, '/');
    }

    /**
     * Retourne le host d'une URL.
     *
     * @param  string  $url
     * @return string|null
     */
    public static function host($url)
    {
        $parse = parse_url($url);

        return $parse['scheme'] . '://' . $parse['host'];
    }

    /**
     * Formate une chaine de caractères en PascalCase.
     *
     * @param  string  $string
     * @return string|null
     */
    public static function pascal($string)
    {
        return static::ucfirst(static::camel($string));
    }

    /**
     * Format une chaine de caractères en PascalCase.
     *
     * @param  string  $string
     * @param  string  $by
     * @return string|null
     */
    public static function replaceSpace($string, $by = '')
    {
        return preg_replace('/\s+/', $by, $string);
    }

    /**
     * Supprime tous les caractères spéciaux d'une chaine.
     *
     * @param  string  $string
     * @return string|null
     */
    public static function removeSpecialChar($string)
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }

    /**
     * Format une chaine de caractères en PascalCase.
     *
     * @param  string  $string
     * @return string|null
     */
    public static function replaceSpecialChars($string)
    {
        $utf8 = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u'  => 'A',
            '/[ÍÌÎÏ]/u'   => 'I',
            '/[íìîï]/u'   => 'i',
            '/[éèêë]/u'   => 'e',
            '/[ÉÈÊË]/u'   => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u'  => 'O',
            '/[úùûü]/u'   => 'u',
            '/[ÚÙÛÜ]/u'   => 'U',
            '/ç/'         => 'c',
            '/Ç/'         => 'C',
            '/ñ/'         => 'n',
            '/Ñ/'         => 'N',
            '/–/'         => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'  => '\'', // Literally a single quote
            '/[“”«»„]/u'  => '"', // Double quote
            '/ /'         => ' ', // nonbreaking space (equiv. to 0x160)
        ];

        return preg_replace(array_keys($utf8), array_values($utf8), $string);
    }

    /**
     * Transforme une chaine au format mac.
     *
     * @param  string  $string
     * @return string|null
     */
    public static function mac($string)
    {
        return wordwrap(static::removeSpecialChar($string), 2, ':', 1);
    }

    /**
     * Remplace une liste de variables dans un text.
     *
     * @param  string  $string
     * @param  array  $replace
     * @return string|null
     */
    public static function replaceArr($string, $replace = [])
    {
        $replace = Arr::implode_keys($replace);

        $replace = array_combine(
            array_map(fn ($k) => "/:$k/", array_keys($replace)),
            $replace
        );

        return preg_replace(array_keys($replace), array_values($replace), $string);
    }

    /**
     * Prefix un chaine par "copie" quand la chaine existe déjà dans la liste.
     *
     * @param  string  $name
     * @param  array  $list
     * @return string
     */
    public static function prefixCopie($string, $list)
    {
        $i = 0;
        while (in_array($string, $list)) {
            $string = Str::before($string, ' - Copie') . ' - Copie' . ($i++ ? "($i)" : '');
        }

        return $string;
    }

    /**
     * Transforme un texte en tableau à partir de ses lignes.
     *
     * @param  string  $string
     * @return array
     */
    public static function toArray($string): array
    {
        $string = Str::replace("\r\n", "\n", $string);

        return explode("\n", $string);
    }

    /**
     * Transforme un texte en json à partir de ses lignes.
     *
     * @param  string  $string
     * @return string
     */
    public static function toJson($string): string
    {
        $string = static::toArray($string);

        return json_encode($string, JSON_UNESCAPED_UNICODE);
    }
}
