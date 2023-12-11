<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use support\Model;

class Topic extends Model
{
    protected $table = 'topics';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
    protected $with = [
        'author:id,username,avatar_uri',
        'board:id,name,color',
    ];
    protected $fillable = ['author_id', 'title', 'last_reply_at'];

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

    public static function createTopic(
        string $title,
        string $content,
        int $board_id,
        int $author_id,
    ): bool|\Illuminate\Database\Eloquent\Model {
        $now = date('Y-m-d\TH:i:s.u');
        $board = Board::find($board_id);
        if (!$board)
            return false;

        $created_topic = $board->topics()->create([
            'author_id' => $author_id,
            'title' => $title,
            'last_reply_at' => $now
        ]);
        $host_discussion = new Discussion();
        $host_discussion->topic_id = $created_topic->id;
        $host_discussion->author_id = $author_id;
        $host_discussion->content = $content;
        $host_discussion->save();

        return $created_topic;
    }
}
