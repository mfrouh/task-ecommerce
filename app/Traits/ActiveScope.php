<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ActiveScope
{
    public function ScopeActive(Builder $query)
    {
        $query->where('status', 1);
    }

    public function ScopeInactive(Builder $query)
    {
        $query->where('status', 0);
    }
}
