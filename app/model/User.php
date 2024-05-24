<?php

namespace app\model;

use App\casts\FullPath;
use support\Model;

class User extends Model
{
    protected $casts = [
        'avatar_uri' => FullPath::class
    ];

    protected $table = 'users';
}
