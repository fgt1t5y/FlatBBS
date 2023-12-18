<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class FullPath implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        var_dump($value);
        return $value;
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
