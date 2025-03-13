<?php

namespace app\controller;

use app\service\UserService;
use app\service\AuthService;
use DI\Attribute\Inject;

class UserController
{
    #[Inject]
    protected UserService $user;
    #[Inject]
    protected AuthService $auth;

    public function info(string $username)
    {
        return ok($this->user->getUserByUsername($username));
    }

    public function topics(string $username, int $page, int $limit)
    {
        return ok(
            $this->user->getUserTopics($username, $page, $limit)
        );
    }

    public function liked(string $username, int $page, int $limit)
    {
        return ok(
            $this->user->getLikedTopics($username, $page, $limit)
        );
    }
}
