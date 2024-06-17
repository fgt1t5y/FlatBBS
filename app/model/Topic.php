<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use support\AbstractModel;
use app\model\Board;
use app\model\User;

class Topic extends AbstractModel
{
    protected $table = 'topics';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
    protected $with = [
        'author:id,display_name,avatar_uri',
        'board:id,name,color,slug',
    ];
    protected $fillable = ['author_id', 'title', 'last_reply_at'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function last_reply(): BelongsTo
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
