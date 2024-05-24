<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use support\Model;
use App\casts\FullPath;

class Board extends Model
{
    protected $table = 'boards';
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'avatar_uri' => FullPath::class,
        'header_img_uri' => FullPath::class
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
