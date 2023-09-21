<?php

namespace app\model;

use support\Model;

class User extends Model
{
    protected $table = 'user';

    public static function hasUser(string $email)
    {
        return self::where('email', $email)->count();
    }
}
