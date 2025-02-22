<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use support\AbstractModel;
use app\model\User;

class UserVisitLog extends AbstractModel
{
    protected $table = 'user_visit_logs';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function visitable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'visitable_type', 'visitable_id');
    }
}
