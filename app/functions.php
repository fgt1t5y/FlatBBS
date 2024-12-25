<?php

use support\Response;

function all(array $value)
{
    foreach ($value as $v) {
        if ($v === '' || !$v || is_null($v)) {
            return false;
        }
    }

    return true;
}

function ok(mixed $data = null): Response
{
    return json(['code' => STATUS_OK, 'data' => $data]);
}

function no(int $code, string $message = ''): Response
{
    return json(['code' => $code, 'message' => $message]);
}

function config_with(string $key, mixed $suffix)
{
    return config($key) . $suffix;
}
