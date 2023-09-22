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
    ) {
        $user = new self();
        $user->email = $email;
        $user->password = md5($password);
        $user->username = $username;

        try {
            $user->save();
            return true;
        } catch (PDOException $e) {
            throw $e;
        }

    }
}
