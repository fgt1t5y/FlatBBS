<?php

namespace app\service;

use support\Redis;

class AuthService
{
    public function logoutAll(int $userId): void
    {
        $sessions = Redis::sMembers("flat_sess_{$userId}");

        if (!$sessions || count($sessions) === 0) {
            return;
        }


        foreach ($sessions as $session) {
            Redis::del("flat_sess_{$session}");
            Redis::sRem("flat_sess_{$userId}", 1, $session);
        }

        return;
    }
}
