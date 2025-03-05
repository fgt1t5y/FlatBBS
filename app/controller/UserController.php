<?php

namespace app\controller;

use app\service\FileService;
use app\service\UserService;
use app\service\AuthService;
use support\Request;
use DI\Attribute\Inject;

class UserController
{
    #[Inject]
    protected FileService $file;
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
        $last_id = $request->get('last');
        $limit = $request->get('limit');

        $result = $this->user->getUserTopics($username, $last_id, $limit);

        return ok($result);
    }

    public function liked(Request $request, string $username)
    {
        $last_id = $request->get('last');
        $limit = $request->get('limit');

        $result = $this->user->getLikedTopics($username, $last_id, $limit);

        return ok($result);
    }
}
