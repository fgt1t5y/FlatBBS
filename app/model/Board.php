<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use support\Model;

class Board extends Model
{
    protected $table = 'boards';

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'board_id');
    }
}
