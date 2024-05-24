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
        $host_discussion->content = $content ?? 'No Content';
        $host_discussion->save();

        return $created_topic;
    }
}
