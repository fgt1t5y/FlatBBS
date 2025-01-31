<?php

namespace app\service;

use support\Redis;

class AuthService
{
    public function logoutAll(int $user_id): void
    {
        $sessions = Redis::sMembers("flat_sess_{$user_id}");

        if (!$sessions || count($sessions) === 0)
            return;

        foreach ($sessions as $session) {
            Redis::del("flat_sess_{$session}");
            Redis::sRem("flat_sess_{$user_id}", 1, $session);
        }

        return;
    }
}
