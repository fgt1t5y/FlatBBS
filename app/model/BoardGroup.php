<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use support\Model;

class BoardGroup extends Model
{
    protected $table = 'board_groups';

    public function boards(): HasMany
    {
        return $this->hasMany(Board::class, 'group_id');
    }
}
