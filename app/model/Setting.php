<?php

namespace app\model;

use support\AbstractModel;

class Setting extends AbstractModel
{
    protected $table = 'settings';

    protected $primaryKey = 'key';

    protected $fillable = ['key', 'value', 'namespace'];

    public $timestamps = false;
}
