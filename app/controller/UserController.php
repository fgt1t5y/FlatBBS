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

    public function info(Request $request, string $username)
    {
        $result = $this->user->getUserByUsername($username);

        if (!$result) {
            return no(STATUS_NOT_FOUND, '$exception.user_not_found');
        }

        return ok($result);
    }

    public function topics(Request $request, string $username)
    {
        $lastId = $request->get('last');
        $limit = $request->get('limit');

        return ok(
            $this->user->getUserTopics($username, $lastId, $limit)
        );
    }

    public function liked(Request $request, string $username)
    {
        $lastId = $request->get('last');
        $limit = $request->get('limit');

        return ok(
            $this->user->getLikedTopics($username, $lastId, $limit)
        );
    }
}
