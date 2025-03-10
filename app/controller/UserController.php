<?php

namespace app\controller;

use app\service\UserService;
use app\service\AuthService;
use support\Request;
use DI\Attribute\Inject;

class UserController
{
    #[Inject]
    protected UserService $user;
    #[Inject]
    protected AuthService $auth;

    public function info(string $username)
    {
        $result = $this->user->getUserByUsername($username);

        if (!$result) {
            return no(STATUS_NOT_FOUND, '$exception.user_not_found');
        }

        return ok($result);
    }

    public function topics(string $username, int $last, int $limit)
    {
        return ok(
            $this->user->getUserTopics($username, $last, $limit)
        );
    }

    public function liked(string $username, int $last, int $limit)
    {
        return ok(
            $this->user->getLikedTopics($username, $last, $limit)
        );
    }
}
