<?php

namespace app\controller;

use app\model\User;
use app\service\FileService;
use app\service\UserService;
use support\Request;
use Shopwwi\LaravelCache\Cache;

class UserController
{
    private $userBasicFields = [
        'id',
        'email',
        'display_name',
        'username',
        'avatar_uri',
        'introduction'
    ];

    protected FileService $fileService;
    protected UserService $userService;

    public function __construct(FileService $fileService, UserService $userService)
    {
        $this->fileService = $fileService;
        $this->userService = $userService;
    }

    public function info(Request $request)
    {
        $uid = session('id');
        $cache_prefix = config('flatbbs.cache.prefix.userinfo');

        $userinfo = Cache::remember(
            "{$cache_prefix}{$uid}",
            config('flatbbs.cache.ttl'),
            function () use ($uid) {
                return User::find($uid, $this->userBasicFields)->toArray();
            }
        );

        return ok($userinfo);
    }

    public function modify(Request $request)
    {
        $field = $request->post('field', '');
        $value = $request->post('value', '');

        $response = $this->userService->modify($field, $value);

        if (!$response->isSuccess()) {
            return no(STATUS_INTERNAL_ERROR);
        }

        return ok();
    }

    public function avatar(Request $request)
    {
        $response = $this->fileService->upload($request->file());

        if (!$response->isSuccess()) {
            return no(STATUS_BAD_REQUEST);
        }
        $newAvatarName = $response->getData();

        $response = $this->userService->modify('avatar_uri', $newAvatarName);

        if ($response->isSuccess()) {
            $response->success();
        } else {
            $response->failed(STATUS_INTERNAL_ERROR);
        }

        return $response;
    }
}
