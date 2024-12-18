<?php

namespace app\controller;

use support\Redis;
use support\Request;
use app\model\User;
use app\service\AuthService;
use DI\Attribute\Inject;

class AuthController
{
    #[Inject]
    protected AuthService $auth;

    public function login(Request $request)
    {
        $session = $request->session();

        if ($session->has('id')) {
            return no(STATUS_BAD_REQUEST, 'i18n$exception.you_are_logged_in');
        }

        $email = $request->post('email');
        $password = $request->post('password');
        $user = User::where('email', $email)->first();

        if (!all([$email, $password]) || !$user) {
            return no(STATUS_BAD_REQUEST, 'i18n$exception.user_not_found');
        }
        if (!password_verify($password, $user->password)) {
            return no(STATUS_FORBIDDEN, 'i18n$exception.password_is_wrong');
        }
        if ($user->allow_login === 0) {
            return no(STATUS_FORBIDDEN, 'i18n$exception.user_has_been_banned');
        }

        $user_id = $user->id;
        $token = random_string();
        $roles = $user->roles->pluck('id')->all();
        $permissions = $user->permissions();
        $session->put([
            'id' => $user_id,
            'username' => $user->username,
            'token' => $token,
            'email' => $email,
            'roles' => $roles,
            'permissions' => $permissions
        ]);
        $user->last_login_at = date('Y-m-d\TH:i:s.u');
        $user->save();
        Redis::sAdd("flat_sess_{$user_id}", $session->getId());

        return ok()
            ->cookie('flat_sess', $token, 43200, '/');
    }

    public function logout(Request $request)
    {
        $session = $request->session();
        $user_id = $session->get('id');

        if (!$user_id) {
            return no(STATUS_UNAUTHORIZED, 'i18n$exception.unauthorized');
        }

        Redis::sRem("flat_sess_{$user_id}", 1, $session->getId());
        $session->flush();

        return ok()
            ->cookie('flat_sess', '', 0, '/');
    }

    public function forget(Request $request)
    {
        $session = $request->session();
        $user_id = $session->get('id');

        if (!$user_id) {
            return no(STATUS_UNAUTHORIZED, 'i18n$exception.unauthorized');
        }

        return $this->auth->logout_all($user_id);
    }
}
