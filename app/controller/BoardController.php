<?php

namespace app\controller;

use app\model\Board;
use app\model\BoardGroup;
use support\Request;

class BoardController
{
    public function groups(Request $request)
    {
        $board_groups = BoardGroup::all('id', 'name');

        return json_message(0, '完成', $board_groups);
    }

    public function boards(Request $request)
    {
        $board_id = $request->post('id');
        $boards = BoardGroup::find($board_id)
            ->boards()->get(['id', 'name', 'color']);

        return  json_message(0, '完成', $boards);
    }
}
