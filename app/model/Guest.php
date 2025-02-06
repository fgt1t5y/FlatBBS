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
        return Permission::query()
            ->where('role_id', 2)->get()
            ->pluck('permission')->all();
    }
}
