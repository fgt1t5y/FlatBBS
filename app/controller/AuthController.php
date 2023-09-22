<?php

namespace app\controller;

use support\Request;
use app\model\User;
use PDOException;

class AuthController
{
    public function register(Request $request)
    {
        $username = $request->post('username');
        $email = $request->post('email');
        $password = $request->post('password');
        if (!all([$username, $password, is_email($email)])) {
            return error_json(400, '表单未完整填写');
        }

        if (User::hasUser($email)) {
            return error_json(400, '此邮箱已被注册');
        }

        try {
            $user = User::newUser($email, $username, $password, true);
            $user->saveOrFail();
            return json([
                'code' => 0,
                'message' => '完成'
            ]);
        } catch (PDOException $e) {
            return error_json(500, $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $session = $request->session();

        if ($session->get('uid') !== null) {
            return error_json(400, '你已经登录过了');
        }

        $email = $request->post('email', 'null');
        $password = $request->post('password');
        $user = User::getUser($email, ['id', 'password', 'allow_login']);

        if (!all([$email, $password]) || $user === false) {
            return error_json(400, '用户不存在');
        }
        if ($user->allow_login === 0) {
            return error_json(403, '你不被允许登录你的账号');
        }
        if (!(md5($password) === $user->password)) {
            return error_json(403, '账号或密码错误');
        }

        $token = random_string();
        $session->put([
            'uid' => $user->id,
            'token' => $token
        ]);
        return json([
            'code' => 0,
            'message' => '完成',
            'token' => $token
        ])->cookie('flat_sess', $token);
    }
}
