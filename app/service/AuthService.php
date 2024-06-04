<?php

namespace app\service;

use support\Redis;

class AuthService
{
    public function logout_all(int $user_id): void
    {
        $sessions = Redis::lRange("flat_sess_{$user_id}", 0, -1);

        if (!$sessions || count($sessions) === 0)
            return;

        foreach ($sessions as $session) {
            Redis::del("flat_sess_{$session}");
            Redis::lRem("flat_sess_{$user_id}", 1, $session);
        }

        return;
    }
}
