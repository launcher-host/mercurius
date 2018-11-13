<?php

namespace Launcher\Mercurius;

use Illuminate\Database\Eloquent\Builder;

trait MercuriusUser
{
    /**
     * Scope the model query to certain users only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeContacts(Builder $query): Builder
    {
        // E.g. filter contacts
        // --------------------------------
        // return $query->where( 'your_logic_goes_here' );

        return $query;
    }
}
