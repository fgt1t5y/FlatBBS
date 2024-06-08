<?php

use support\Response;

function is_email(string $email)
{
    if (strlen($email) > 64) {
        return false;
    }

    if (preg_match('/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/', $email)) {
        return true;
    }

    return false;
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
    $unit = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $len = strlen($unit) - 1;
    $result = '';

    for ($i = 0; $i < 16; $i++) {
        $result = $result . $unit[random_int(0, $len)];
    }

    return $result;
}

function is_login($token)
{
    $server_token = session('token');
    if ($server_token === null) {
        return false;
    }

    if ($server_token === $token) {
        return true;
    }

    session()->flush();
    return false;
}

function config_with(string $key, mixed $suffix)
{
    return config($key) . $suffix;
}
