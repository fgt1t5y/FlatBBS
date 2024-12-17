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

    public function info_by_username(string $username, array $columns)
    {
        return User::where('username', $username)->first($columns);
    }

    public function topics(string $username, int $last_id, int $limit)
    {
        return User::where('username', $username)
            ->firstOrFail()
            ->topics()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id)
            ->orderByDesc('created_at')
            ->get();
    }

    public function modify(int $user_id, string $field, string $value): bool
    {
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
