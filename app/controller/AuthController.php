<?php

namespace app\controller;

use support\Redis;
use support\Request;
use app\model\User;

class AuthController
{
    public function login(Request $request)
    {
        $session = $request->session();

        if (is_login($request->cookie('flat_sess'))) {
            return no(STATUS_BAD_REQUEST, '你已经登录过了');
        }

        $email = $request->post('email');
        $password = $request->post('password');
        $user = User::where('email', $email)->first();

        if (!all([$email, $password]) || !$user) {
            return no(STATUS_BAD_REQUEST, '用户不存在');
        }
        if (!password_verify($password, $user->password)) {
            return no(STATUS_FORBIDDEN, '账号或密码错误');
        }
        if ($user->allow_login === 0) {
            return no(STATUS_FORBIDDEN, '你不被允许登录你的账号');
        }

        $token = random_string();
        $session->put([
            'id' => $user->id,
            'token' => $token,
            'email' => $email
        ]);
        $user->last_login_at = date('Y-m-d\TH:i:s.u');
        $user->save();
        Redis::rPush('flat_sess_' . $user->id, $session->getId());

        return ok()
            ->cookie('flat_sess', $token, 43200, '/');
    }

    public function logout(Request $request)
    {
        $session = $request->session();
        Redis::lRem('flat_sess_' . $session->get('id'), 1, $session->getId());
        $session->flush();

        return ok()
            ->cookie('flat_sess', '', 0, '/');
    }
}
