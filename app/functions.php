<?php

use support\Response;
use Workerman\Protocols\Http\Session;

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

function json_message(int $code, string $message, mixed $data = null): Response
{
    return new Response(
        200,
        ['Content-Type' => 'application/json'],
        json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ])
    );
}

function random_string()
{
    $unit = 'abcdefghijklmnopqrstuvwxyz1234567890';
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
