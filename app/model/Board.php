<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use support\AbstractModel;
use App\casts\FullPath;

class Board extends AbstractModel
{
    protected $table = 'boards';
    protected $casts = [
        'avatar_uri' => FullPath::class,
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
