<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use support\AbstractModel;
use app\model\Permission;
use app\model\User;

class Role extends AbstractModel
{
    protected $table = 'roles';

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
