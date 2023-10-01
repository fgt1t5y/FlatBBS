<?php

namespace app\controller;

use support\Request;
use app\model\User;
use Exception;
use Intervention\Image\ImageManagerStatic as image;

class AuthController
{
    public function register(Request $request)
    {
        $username = $request->post('username');
        $email = $request->post('email');
        $password = $request->post('password');
        if (!all([$username, $password, is_email($email)])) {
            return json_message(400, '表单未完整填写');
        }

        if (User::hasUser($email)) {
            return json_message(400, '此邮箱已被注册');
        }

        try {
            $avatar_filename = random_string() . '.png';
            $avatar = image::make('public/DefaultAvatar.png');
            $avatar->save("public/usercontent/{$avatar_filename}", 60);
            $user = User::newUser(
                $email,
                $username,
                $password,
                $avatar_filename,
                true
            );
            $user->saveOrFail();
            return json_message(0, '完成');
        } catch (Exception $e) {
            return json_message(500, $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $session = $request->session();

        if (is_login($session, $request->cookie('flat_sess'))) {
            return json_message(400, '你已经登录过了');
        }

        $email = $request->post('email', 'null');
        $password = $request->post('password');
        $user = User::getUser($email, ['id', 'password', 'allow_login']);

        if (!all([$email, $password]) || $user === false) {
            return json_message(400, '用户不存在');
        }
        if (!(md5($password) === $user->password)) {
            return json_message(403, '账号或密码错误');
        }
        if ($user->allow_login === 0) {
            return json_message(403, '你不被允许登录你的账号');
        }

        $token = random_string();
        $session->put([
            'uid' => $user->id,
            'token' => $token,
            'email' => $email
        ]);
        $user->last_login_at = date('Y-m-d H:i:s');
        $user->save();

        return json_message(0, '完成')
            ->cookie('flat_sess', $token, 43200, '/');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return json_message(0, '完成')
            ->cookie('flat_sess', '', 0, '/');
    }
}
