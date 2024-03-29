<?php

namespace app\model;

use App\Casts\FullPath;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use support\Model;

class User extends Model
{
    static $allowModifyColumn = [
        'avatar_uri',
        'display_name',
        'introduction'
    ];

    protected $casts = [
        'avatar_uri' => FullPath::class
    ];

    protected $table = 'users';

    public static function hasUser(string $email)
    {
        return self::where('email', $email)->count();
    }

    public static function getUser(string $column, string $value, array $need = ['id'])
    {
        try {
            return self::where($column, $value)->firstOrFail($need);
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public static function getUserById(int $uid, array $columns = ['id'])
    {
        return self::getUser('id', $uid, $columns);
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
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->username = $username;
        $user->avatar_uri = $avatar_uri;
        $user->allow_login = $allow_login ? 1 : 0;

        return $user;
    }

    public static function modifyUser(
        int $uid,
        string $field,
        string $value
    ): bool {
        if (
            !all([$field, $value])
            || !in_array($field, self::$allowModifyColumn)
        ) {
            return false;
        }

        $user = self::getUserById($uid);
        if (!$user)
            return false;
        $user->$field = $value;

        try {
            $user->save();
        } catch (Exception) {
            return false;
        }

        return true;
    }
}
