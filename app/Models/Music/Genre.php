<?php

namespace App\Models\Music;

use App\Scopes\GenreScope;

class Genre extends Tag
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new GenreScope);

        static::creating(function ($genre) {
            $genre->tag_type_id = parent::GENRE;
        });
    }
}
