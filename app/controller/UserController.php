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

    public function info(Request $request)
    {
        $user_id = session('id');

        if (!$user_id) {
            return no(STATUS_UNAUTHORIZED, 'i18n$exception.unauthorized');
        }

        return ok($this->user->info($user_id));
    }

    public function modify(Request $request)
    {
        $request->assertLogin();

        $field = $request->post('field');
        $value = $request->post('value');
        $user_id = session('id');

        $result = $this->user->modify($user_id, $field, $value);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        }

        return ok();
    }

    public function detail(Request $request)
    {
        $user_id = $request->get('user_id');
        $username = $request->get('username');

        if ($user_id) {
            $result = $this->user->info($user_id);
        } elseif ($username) {
            $result = $this->user->info_by_username($username);
        } else {
            $result = null;
        }

        if (!$result) {
            return no(STATUS_NOT_FOUND, 'i18n$exception.user_not_found');
        }

        return ok($result);
    }

    public function topics(Request $request, string $username)
    {
        $last_id = $request->get('last');
        $limit = $request->get('limit');

        $result = $this->user->topics($username, $last_id, $limit);

        return ok($result);
    }

    public function liked(Request $request, string $username)
    {
        $last_id = $request->get('last');
        $limit = $request->get('limit');

        $result = $this->user->liked_topics($username, $last_id, $limit);

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

        $result = $this->user->modify($user_id, 'avatar_uri', $newAvatarName);

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
        $result = $this->user->modify($user->id, 'password', $new_password);

        $this->auth->logout_all($user->id);

        if (!$result) {
            return no(STATUS_INTERNAL_ERROR);
        } else {
            return ok();
        }
    }
}
