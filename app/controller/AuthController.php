<?php

namespace app\controller;

use support\Request;
use app\model\User;
use PDOException;

class AuthController
{
    // Create a new acount.
    public function register(Request $request)
    {
        $username = $request->post('username');
        $email = $request->post('email');
        $password = $request->post('password');
        if (!all([$username, $password, is_email($email)])) {
            return json([
                'code' => 500,
                'message' => '表单未完整填写'
            ]);
        }

        $user = new User();
        $user->email = $email;
        $user->password = md5($password);
        $user->username = $username;

        try {
            $user->save();
        } catch (PDOException $e) {
            return json([
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
