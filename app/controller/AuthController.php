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
        $email = $request->post('email');
        $user = User::getUser($email);

        if (!all([$email]) || $user === false) {
            return error_json(400, '用户不存在');
        }
    }

    public function test(Request $request)
    {
        $session = $request->session();
        $session->set('test', 'ok');
    }
}
