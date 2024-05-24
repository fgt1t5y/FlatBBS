<?php

namespace app\service;

use app\model\User;

class UserService
{
    private $allowModifyColumn = [
        'avatar_uri',
        'display_name',
        'introduction'
    ];

    public function modify(string $field, string $value)
    {
        $uid = session('id');
        $response = response();

        if (
            !all([$value])
            || !in_array($field, $this->allowModifyColumn)
        ) {
            return $response;
        }

        $user = User::find($uid);
        $user->$field = $value;

        if ($user->save()) {
            return $response->success();
        } else {
            return $response;
        }
    }
}
