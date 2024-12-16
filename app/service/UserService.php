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

    public function info(int $user_id, array $columns)
    {
        return User::find($user_id, $columns);
    }

    public function modify(string $field, string $value): bool
    {
        $user_id = session('id');

        if (
            !all([$value])
            || !in_array($field, $this->allowModifyColumn)
        ) {
            return false;
        }

        $user = User::find($user_id);
        $user->$field = $value;

        if (!$user->isDirty()) {
            return true;
        }

        return $user->save();
    }
}
