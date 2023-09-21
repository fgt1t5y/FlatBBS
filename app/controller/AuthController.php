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
            return error_json(400, [
                'code' => 400,
                'message' => '表单未完整填写'
            ]);
        }

        if (User::hasUser($email)) {
            return error_json(400, [
                'code' => 400,
                'message' => '此邮箱已被注册'
            ]);
        }

        $user = new User();
        $user->email = trim($email);
        $user->password = md5(trim($password));
        $user->username = trim($username);

        try {
            $user->save();
        } catch (PDOException $e) {
            return error_json(500, [
                'code' => 500,
                'message' => $e->getMessage()
            ]);
        }

        return json([
            'code' => 0,
            'message' => '完成'
        ]);
    }
}
