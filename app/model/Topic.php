<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use support\AbstractModel;
use app\model\Board;
use app\model\User;

class Topic extends AbstractModel
{
    public static $topicBasicFields = [
        'id',
        'title',
        'author_id',
        'board_id',
        'reply_count',
        'created_at'
    ];

    protected $table = 'topics';
    protected $with = [
        'author:id,display_name,avatar_uri',
        'board:id,name,color,slug',
    ];
    protected $fillable = ['author_id', 'title', 'last_reply_at'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }
}
