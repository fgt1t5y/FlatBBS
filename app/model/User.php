<?php

namespace app\model;

use App\casts\FullPath;
use support\AbstractModel;

class User extends AbstractModel
{
    protected $casts = [
        'avatar_uri' => FullPath::class
    ];

    protected $table = 'users';

    public static $basic_columns = [
        'id',
        'display_name',
        'username',
        'email',
        'avatar_uri',
        'header_image_uri',
        'introduction'
    ];
}
