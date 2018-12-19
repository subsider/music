<?php

namespace App\Models\Music;

use App\Scopes\LabelScope;

class Label extends Company
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LabelScope);

        static::creating(function ($genre) {
            $genre->company_type_id = parent::LABEL;
        });
    }
}
