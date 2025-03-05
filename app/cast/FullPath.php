<?php

namespace app\cast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class FullPath implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return getenv('LOCAL_USERCONTENT_ENDPOINT') . $value;
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
