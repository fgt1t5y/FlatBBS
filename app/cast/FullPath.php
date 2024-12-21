<?php

namespace app\cast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class FullPath implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return config_with('flatbbs.assets_path', $value);
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
