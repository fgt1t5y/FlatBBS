<?php

namespace support;

use support\Model;
use support\EventManager;

class AbstractModel extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->attributes = [];

        parent::__construct($attributes);
    }

    protected static function boot(): void
    {
        parent::boot();
    }
}
