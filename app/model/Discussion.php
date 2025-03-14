<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use support\AbstractModel;
use app\model\DiscussionReply;

class Discussion extends AbstractModel
{
    protected $table = 'discussions';

    protected $with = ['author:id,username,display_name,avatar_uri', 'top_replies'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class);
    }

    public function top_replies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class)->limit(5);
    }
}
