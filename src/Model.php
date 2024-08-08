<?php

namespace Nerow\Tools;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel
{
    use HasFactory;

    /**
     * Si l'on souhaite accèder à l'attribut via une méthode du même nom.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return method_exists($this, $key)
             ? $this->resolver($key)
             : parent::__get($key); // Par défaut
    }

    /**
     * Etend les possibilités de retour d'une méthode.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function resolver($key)
    {
        $method = $this->$key();

        // Ajout du cas Builder
        if ($method instanceof Builder) {
            return substr($key, -1) === 's'
                    ? $method->get()
                    : $method->first();
        }

        return ! is_null($method)
             ? parent::__get($key)
             : null;
    }

    /**
     * Retourne le nom de la table.
     */
    public static function getTableName()
    {
        return (new static)->getTable();
    }

    /**
     * Premet d'exclure des ids.
     */
    public function scopeExcept($query, array $ids): void
    {
        $query->whereNotIn('id', $ids);
    }

    /**
     * Retourne la dernière entrée de la table.
     */
    public static function last(): ?self
    {
        return self::orderByDesc('id')->first();
    }

    /**
     * Override.
     */
    public function toArray(array $replace = [], array $only = [], array $except = []): array
    {
        $collection = collect(parent::toArray());

        if (! empty($only)) {
            $collection = $collection->only($only);
        }

        $collection = $collection->except($except);

        $fillable = array_flip(array_merge($this->getFillable(), $this->getHidden()));

        $replace = array_intersect_key($replace, $fillable);

        return $collection->merge($replace)->toArray();
    }
}
