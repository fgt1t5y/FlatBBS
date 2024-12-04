<?php

namespace app\controller;

use app\model\User;
use app\service\FileService;
use app\service\UserService;
use app\service\AuthService;
use support\Request;
use DI\Attribute\Inject;
use support\Gate;

class UserController
{
    #[Inject]
    protected FileService $file;
    #[Inject]
    protected UserService $user;
    #[Inject]
    protected AuthService $auth;

    #[Gate('user:query')]
    public function info(Request $request)
    {
        $uid = session('id');

        $userinfo = $this->user->info($uid, User::$basic_columns);

        return ok($userinfo);
    }

    #[Gate('user:modify')]
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

    public function user(Request $request)
    {
        $user_id = $request->post('username');

        $result = $this->user->info($user_id, User::$basic_columns);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        }

        return ok($result);
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

        if (!all([$old_password, $new_password]) || $old_password === $new_password) {
            return no(STATUS_BAD_REQUEST);
        }

        $user = $request->getUser();

        if (!password_verify($old_password, $user->password)) {
            return no(STATUS_FORBIDDEN, '密码错误');
        }

        $new_password = password_hash($new_password, PASSWORD_DEFAULT);

        $result = $this->user->modify('password', $new_password);
        $this->auth->logout_all($user->id);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        } else {
            return ok();
        }
    }
}
