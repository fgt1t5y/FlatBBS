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

        static::saving(function (self $model) {
            EventManager::dispatchModelEvent(static::class, 'saving', $model);
        });

        static::saved(function (self $model) {
            EventManager::dispatchModelEvent(static::class, 'saved', $model);
        });

        static::deleting(function (self $model) {
            EventManager::dispatchModelEvent(static::class, 'deleting', $model);
        });

        static::deleted(function (self $model) {
            EventManager::dispatchModelEvent(static::class, 'deleted', $model);
        });
    }

    public static function listen(string $event, callable $callback): void
    {
        EventManager::addModelListener(static::class, $event, $callback);
    }

    public static function dispatch(string $event, $model)
    {
        EventManager::dispatchModelEvent(static::class, $event, $model);
    }
}
