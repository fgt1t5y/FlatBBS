<?php

namespace app\service;

use app\model\User;

class UserService
{
    private $allowModifyColumns = [
        'avatar_uri',
        'display_name',
        'introduction',
        'password'
    ];

    public function getInfo(int $user_id)
    {
        return User::find($user_id);
    }

    public function getInfoById(string $username)
    {
        return User::where('username', $username)->first();
    }

    public function getUserTopics(string $username, int $last_id, int $limit)
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

    public function modifyUserInfo(int $user_id, array $data): bool
    {
        if (!is_array($data) || !count($data)) {
            return false;
        }

        $user = User::find($user_id);

        if (!$user) {
            return false;
        }

        foreach ($data as $attribute => $value) {
            if (in_array($attribute, $this->allowModifyColumns)) {
                $user->setAttribute($attribute, $value);
            }
        }

        if (!$user->isDirty()) {
            return true;
        }

        return $user->save();
    }
}
