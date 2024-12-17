<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use support\AbstractModel;

class Discussion extends AbstractModel
{
    protected $table = 'discussions';
    protected $with = ['author:id,username,display_name,avatar_uri'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
