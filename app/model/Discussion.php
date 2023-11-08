<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use support\Model;

class Discussion extends Model
{
    protected $table = 'discussions';

    protected $with = ['author:id,username,avatar_uri'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
