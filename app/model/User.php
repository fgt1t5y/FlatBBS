<?php

namespace app\model;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use support\Model;
use PDOException;

class User extends Model
{
    protected $table = 'user';

    public static function hasUser(string $email)
    {
        return self::where('email', $email)->count();
    }

    public static function getUser(string $email, array $columns = ['id'])
    {
        try {
            return self::where('email', $email)->firstOrFail($columns);
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public static function newUser(
        string $email,
        string $username,
        string $password,
        string $avatar_uri,
        bool $allow_login,
    ) {
        $user = new self();
        $user->email = strtolower(trim($email));
        $user->password = md5($password);
        $user->username = $username;
        $user->avatar_uri = $avatar_uri;
        $user->allow_login = $allow_login ? 1 : 0;

        return $user;
    }
}
