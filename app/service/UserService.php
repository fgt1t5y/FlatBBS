<?php

namespace app\service;

use app\model\User;

class UserService
{
    private $allowModifyColumn = [
        'avatar_uri',
        'display_name',
        'introduction',
        'password'
    ];

    public function modify(string $field, string $value): bool
    {
        $uid = session('id');

        if (
            !all([$value])
            || !in_array($field, $this->allowModifyColumn)
        ) {
            return false;
        }

        $user = User::find($uid);
        $user->$field = $value;

        if (!$user->isDirty()) {
            return true;
        }

        return $user->save();
    }
}
