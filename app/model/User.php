<?php

namespace app\model;

use app\cast\FullPath;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use support\AbstractModel;
use app\model\Role;
use app\model\Permission;
use app\model\Topic;

class User extends AbstractModel
{
    protected $table = 'users';

    protected $casts = [
        'avatar_uri' => FullPath::class
    ];

    protected $hidden = ['password'];

    protected $with = ['roles:id,name',];

    public function isGuest(): bool
    {
        return false;
    }

    public function getPermissions(): array
    {
        return Permission::whereIn('role_id', $this->roles
            ->pluck('id')->all())->get()
            ->pluck('permission')->all();
    }

    public function hasPermission($permission): bool
    {
        return in_array($permission, $this->getPermissions());
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'author_id');
    }

    public function liked_topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'topic_like', 'user_id', 'topic_id');
    }

    public function visit_logs(): HasMany
    {
        return $this->hasMany(UserVisitLog::class);
    }
}
