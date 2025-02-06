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

    public function modify(Request $request)
    {
        $request->assertLogin();

        $field = $request->post('field');
        $value = $request->post('value');
        $user_id = session('id');

        $result = $this->user->modifyUserInfo($user_id, $field, $value);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        }

        return ok();
    }

    public function detail(Request $request)
    {
        $username = $request->get('username');

        $result = $this->user->getInfoById($username);

        if (!$result) {
            return no(STATUS_NOT_FOUND, 'i18n$exception.user_not_found');
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

    public function avatar(Request $request)
    {
        $request->assertLogin();

        $file_array = $this->file->upload($request->file());

        if (!$file_array) {
            return no(STATUS_BAD_REQUEST, 'i18n$exception.fill_out_form_completely');
        }

        $newAvatarName = $file_array[0];
        $user_id = session('id');

        $result = $this->user->modifyUserInfo($user_id, 'avatar_uri', $newAvatarName);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        } else {
            return ok();
        }
    }

    public function password(Request $request)
    {
        $request->assertLogin();

        $old_password = $request->post('old_password');
        $new_password = $request->post('new_password');

        if (!all([$old_password, $new_password]) || $old_password === $new_password) {
            return no(STATUS_BAD_REQUEST);
        }

        $user = $request->getUser();

        if (!password_verify($old_password, $user->password)) {
            return no(STATUS_FORBIDDEN, 'i18n$exception.password_is_wrong');
        }

        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $result = $this->user->modifyUserInfo($user->id, 'password', $new_password);

        $this->auth->logoutAll($user->id);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        } else {
            return ok();
        }
    }
}
