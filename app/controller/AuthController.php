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
            User::newUser($email, $username, $password);
            return json([
                'code' => 0,
                'message' => '完成'
            ]);
        } catch (PDOException $e) {
            error_json(500, $e->getMessage());
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
}
