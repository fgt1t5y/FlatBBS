<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use support\Model;

class Topic extends Model
{
    protected $table = 'topics';

    protected $with = [
        'author:id,username,avatar_uri',
        'board:id,name,color',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function last_reply(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_reply_id');
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class, 'topic_id');
    }
}
