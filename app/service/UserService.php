<?php

namespace app\service;

use app\model\User;

class UserService
{
    const AllowModifyColumns = [
        'avatar_uri',
        'display_name',
        'introduction',
        'password'
    ];

    public function getUserByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    public function getUserTopics(string $username, int $page, int $limit)
    {
        return User::where('username', $username)
            ->first()
            ->topics()
            ->orderByDesc('created_at')
            ->limit(min($limit, 50))
            ->offset(($page - 1) * $limit)
            ->get();
    }

    public function getLikedTopics(string $username, int $page, int $limit)
    {
        return User::where('username', $username)
            ->first()
            ->liked_topics()
            ->orderByDesc('created_at')
            ->limit(min($limit, 50))
            ->offset(($page - 1) * $limit)
            ->get();
    }

    public function modifyUserInfo(User $user, array $data): bool
    {
        if (!$user || $user->isGuest()) {
            return false;
        }

        foreach ($data as $attribute => $value) {
            if (in_array($attribute, self::AllowModifyColumns)) {
                $user->setAttribute($attribute, $value);
            }
        }

        if (!$user->isDirty()) {
            return true;
        }

        return $user->save();
    }
}
