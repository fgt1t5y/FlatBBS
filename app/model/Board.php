<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use support\AbstractModel;
use App\casts\FullPath;

class Board extends AbstractModel
{
    protected $table = 'boards';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'avatar_uri' => FullPath::class,
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
