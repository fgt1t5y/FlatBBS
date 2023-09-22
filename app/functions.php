<?php

use support\Response;

function is_email(string $email)
{
    if (preg_match('/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/', $email)) {
        return true;
    }

    return false;
}

function all(array $value)
{
    foreach ($value as $v) {
        if ($v === "" || !$v || is_null($v)) {
            return false;
        }
    }

    return true;
}

function error_json(int $code, string $message): Response
{
    return new Response(
        $code,
        ['Content-Type' => 'application/json'],
        json_encode([
            'code' => $code,
            'message' => $message
        ])
    );
}

function random_string()
{
    $unit = ['a', 'b', 'c', 'd', 'e', 'f', 'g', '1', '2', '3', '4', '5'];
    $result = '';

    for ($i = 0; $i < 16; $i++) {
        $result = $result . $unit[random_int(0, 9)];
    }

    return $result;
}
