<?php

namespace app\model;

use app\model\User;

class Guest extends User
{
    public int $id = 0;

    public function isGuest(): bool
    {
        return false;
    }
}
