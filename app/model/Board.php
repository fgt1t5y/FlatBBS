<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use support\Model;

class Board extends Model
{
    protected $table = 'boards';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'board_id');
    }
}
