<?php

namespace app\controller;

use Carbon\Carbon;
use support\Redis;
use support\Request;
use app\model\User;
use app\service\AuthService;
use DI\Attribute\Inject;
use Illuminate\Support\Str;

class AuthController
{
    #[Inject]
    protected AuthService $auth;

    public function login(Request $request)
    {
        $session = $request->session();

        $email = $request->post('email');
        $password = $request->post('password');
        $user = User::where('email', $email)->first();

        if (!all([$email, $password]) || !$user) {
            return no(STATUS_BAD_REQUEST, '$exception.user_not_found');
        }
        if (!password_verify($password, $user->password)) {
            return no(STATUS_FORBIDDEN, '$exception.password_is_wrong');
        }
        if ($user->allow_login === 0) {
            return no(STATUS_FORBIDDEN, '$exception.user_has_been_banned');
        }

        $token = Str::random();
        $roles = $user->roles->pluck('id')->all();
        $permissions = $user->getPermissions();

        $session->put(array_merge($user->toArray(), [
            'token' => $token,
            'roles' => $roles,
            'permissions' => $permissions
        ]));
        $user->last_login_at = Carbon::now();
        $user->save();
        Redis::sAdd("flat_sess_{$user->id}", $session->getId());

        return ok()
            ->cookie('flat_sess', $token, 43200, '/');
    }

    public function logout(Request $request)
    {
        $request->assertLogin();

        $session = $request->session();
        $user_id = $session->get('id');

        Redis::sRem("flat_sess_{$user_id}", 1, $session->getId());
        $session->flush();

        return ok()
            ->cookie('flat_sess', '', 0, '/');
    }

    public function forget(Request $request)
    {
        $request->assertLogin();

        $session = $request->session();
        $user_id = $session->get('id');

        return $this->auth->logoutAll($user_id);
    }
}
