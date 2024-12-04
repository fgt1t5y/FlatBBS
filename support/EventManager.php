<?php

namespace support;

class EventManager
{
    private static $instance;

    private static array $callbacks = [];

    public static function getInstance(): self
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public static function addListener(string $event, callable $callback)
    {
        if (empty($event) || !is_callable($callback)) return;

        static::$callbacks[$event][] = $callback;
    }

    public static function dispatchListener(string $event, mixed $data)
    {
        foreach (static::$callbacks[$event] ?? [] as $callback) {
            $callback($data);
        }
    }

    public static function addModelListener(string $ns, string $event, callable $callback)
    {
        static::addListener("$ns:$event", $callback);
    }

    public static function dispatchModelEvent(string $ns, string $event, mixed $model)
    {
        static::dispatchListener("$ns:$event", $model);
    }

    public function ping()
    {
        return 'pong';
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }

}
