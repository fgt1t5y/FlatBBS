<?php

namespace app\model;

use app\model\User;
use app\model\Permission;

class Guest extends User
{
    public int $id = 0;

    public function isGuest(): bool
    {
        return true;
    }

    public function permissions(): array
    {
        if ($this->permissions === null) {
            $this->permissions = Permission::query()
                ->where('role_id', GROUP_GUEST)->get()
                ->pluck('permission')->all();
        }

        return $this->permissions;
    }
}
