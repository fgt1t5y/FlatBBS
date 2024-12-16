<?php

namespace app\model;

use app\casts\FullPath;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use support\AbstractModel;
use app\model\Role;
use app\model\Permission;
use Illuminate\Database\Eloquent\Builder;

class User extends AbstractModel
{
    protected $casts = [
        'avatar_uri' => FullPath::class
    ];

    protected $table = 'users';

    protected $with = [
        'roles:id,name,description',
    ];

    public static $basic_columns = [
        'id',
        'display_name',
        'username',
        'email',
        'avatar_uri',
        'introduction'
    ];

    public function isGuest(): bool
    {
        return true;
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function permissions(): array
    {
        return Permission::query()
            ->whereIn('role_id', $this->roles
                ->pluck('id')->all())->get()
            ->pluck('permission')->all();
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions());
    }
}
