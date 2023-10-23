<?php

namespace app\controller;

use app\model\Board;
use support\Request;

class BoardController
{
    public function boards(Request $request)
    {
        $boards = Board::orderByDesc('id')
            ->get(['id', 'name', 'color']);

        return json_message(STATUS_OK, '完成', $boards);
    }
}
