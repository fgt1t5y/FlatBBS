<?php

namespace app\controller;

use app\model\User;
use app\service\FileService;
use app\service\UserService;
use app\service\AuthService;
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

    protected FileService $file;
    protected UserService $user;
    protected AuthService $auth;

    public function __construct(
        FileService $file,
        UserService $user,
        AuthService $auth
    ) {
        $this->file = $file;
        $this->user = $user;
        $this->auth = $auth;
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

        $result = $this->user->modify($field, $value);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        }

        return ok();
    }

    public function avatar(Request $request)
    {
        $file_array = $this->file->upload($request->file());

        if (!$file_array) {
            return no(STATUS_BAD_REQUEST);
        }
        $newAvatarName = $file_array[0];

        $result = $this->user->modify('avatar_uri', $newAvatarName);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        } else {
            return ok();
        }
    }

    public function password(Request $request)
    {
        $old_password = $request->post('old_password');
        $new_password = $request->post('new_password');
        $session = $request->session();
        $uid = (int) $session->get('id');

        if (!all([$old_password, $new_password]) || $old_password === $new_password) {
            return no(STATUS_BAD_REQUEST);
        }

        $user = User::find($uid)->first();

        if (!password_verify($old_password, $user->password)) {
            return no(STATUS_FORBIDDEN, '密码错误');
        }

        $new_password = password_hash($new_password, PASSWORD_DEFAULT);

        $result = $this->user->modify('password', $new_password);
        $this->auth->logout_all($uid);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        } else {
            return ok();
        }
    }
}
