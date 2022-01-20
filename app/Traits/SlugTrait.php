<?php

namespace App\Traits;

trait SlugTrait
{
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->slug = str_replace(' ', '-', $model->name);
        });
    }
}
