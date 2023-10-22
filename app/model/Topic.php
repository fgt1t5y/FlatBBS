<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use support\Model;

class Topic extends Model
{
    protected $table = 'topics';

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
