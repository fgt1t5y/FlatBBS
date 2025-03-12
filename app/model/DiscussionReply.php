<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use support\AbstractModel;

class DiscussionReply extends AbstractModel
{
    protected $table = 'discussion_replied';

    protected $with = [
        'author:id,username,display_name,avatar_uri',
        'reply_to_user:id,username,display_name,avatar_uri'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reply_to_user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
