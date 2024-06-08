<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use support\AbstractModel;

class Discussion extends AbstractModel
{
    protected $table = 'discussions';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
    protected $with = ['author:id,display_name,avatar_uri'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
