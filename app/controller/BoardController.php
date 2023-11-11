<?php

namespace app\controller;

use app\model\Board;
use support\Request;
use Shopwwi\LaravelCache\Cache;

class BoardController
{
    public function boards(Request $request)
    {
        $boards = Cache::remember('all_boards', config('flatbbs.cache.ttl'), function () {
            return Board::orderByDesc('id')->get(['id', 'name', 'color'])->toArray();
        });

        return json_message(STATUS_OK, '完成', $boards);
    }
}
