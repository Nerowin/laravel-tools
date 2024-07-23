<?php

namespace App\Traits;

trait HasParent
{

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Est parent.
     */
    public function scopeParent($query)
    {
        $query->has('childs');
    }

    /**
     * Est enfant.
     */
    public function scopeChild($query)
    {
        $query->has('parent');
    }

    /**
     * N'est pas enfant.
     */
    public function scopeWithoutParent($query)
    {
        $query->whereDoesntHave('parent');
    }

    /**
     * N'est pas parent.
     */
    public function scopeWithoutChild($query)
    {
        $query->whereDoesntHave('childs');
    }

    /**
     * Sans relation parent/enfant.
     */
    public function scopeSimple($query)
    {
        $query->withoutParent()->withoutChild();
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Relation parent.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    /**
     * Relation enfants.
     *
     * @return array<int,\Illuminate\Database\Eloquent\Model>
     */
    public function childs()
    {
        return $this->hasMany($this, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Functions
    |--------------------------------------------------------------------------
    */

    /**
     * Est parent ?
     *
     * @return bool
     */
    public function isParent(): bool
    {
        return (bool) $this->childs()->count();
    }

    /**
     * Est enfant ?
     *
     * @return bool
     */
    public function isChild(): bool
    {
        return (bool) $this->parent()->count();
    }

    /**
     * Est sans enfant/parent ?
     *
     * @return bool
     */
    public function isSimple(): bool
    {
        return ! $this->isParent() && ! $this->isChild();
    }

}
