<?php

namespace app\service;

use app\model\User;

class UserService
{
    private $allow_modify_column = [
        'avatar_uri',
        'display_name',
        'introduction',
        'password'
    ];

    public function info(int $user_id)
    {
        return User::find($user_id);
    }

    public function getInfoById(string $username)
    {
        return User::where('username', $username)->first();
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

    public function getLikedTopics(string $username, int $last_id, int $limit)
    {
        return User::where('username', $username)
            ->first()
            ->liked_topics()
            ->limit(min($limit, 50))
            ->where('topic_id', '>', $last_id)
            ->orderByDesc('created_at')
            ->get();
    }

    public function modify(int $user_id, string $field, string $value): bool
    {
        if (
            !all([$value])
            || !in_array($field, $this->allow_modify_column)
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
