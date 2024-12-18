<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Expression;
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
        'author:id,username,display_name,avatar_uri',
        'board:id,name,slug',
        'likes:id,username'
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

    public function likes(): BelongsToMany
    {
        $grammer = $this->getQuery()->getGrammar();
        $user_id = request()->getUser()->id;

        return $this->belongsToMany(User::class, 'topic_like', 'topic_id', 'user_id')
            ->orderBy(new Expression($grammer->wrap('user_id') . '=' . $user_id))
            ->limit(5)
            ->applyScopes();
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }
}
