<?php

namespace app\controller;

use app\model\Board;
use support\Request;

class BoardController
{
    public function boards(Request $request)
    {
        $boards = Board::orderByDesc('id')
            ->limit(4)
            ->get(['id', 'name', 'color']);

        return json_message(0, '完成', $boards);
    }
}
