<?php

use support\Response;
use Illuminate\Support\Str;

function is_email(string $email)
{
    if (strlen($email) > 64) {
        return false;
    }

    return preg_match('/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/', $email);
}

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

function random_string()
{
    return Str::random();
}

function config_with(string $key, mixed $suffix)
{
    return config($key) . $suffix;
}
