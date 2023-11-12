<?php

namespace app\controller;

use support\Request;

class UtilsController
{
    public function mess(Request $request)
    {
        return ok(random_string());
    }
}
