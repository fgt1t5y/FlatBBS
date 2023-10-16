<?php

namespace app\controller;

use app\model\BoardGroup;
use support\Request;

class BoardController
{
    public function groups(Request $request)
    {
        $board_groups = BoardGroup::all('id', 'name');

        return json_message(0, '完成', $board_groups);
    }
}
