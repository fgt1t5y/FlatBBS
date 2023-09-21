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

function error_json(int $code, mixed $json): Response
{
    return new Response($code, ['Content-Type' => 'application/json'], json_encode($json));
}
