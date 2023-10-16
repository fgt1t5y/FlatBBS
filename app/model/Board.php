<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use support\Model;

class Board extends Model
{
    protected $table = 'boards';

    public function group(): BelongsTo
    {
        return $this->belongsTo(BoardGroup::class);
    }
}
