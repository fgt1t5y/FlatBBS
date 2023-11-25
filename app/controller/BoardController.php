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

        return ok($boards);
    }

    public function info(Request $request)
    {
        $board_id = (int) $request->post('board');

        if ($board_id <= 0) {
            no(STATUS_BAD_REQUEST);
        }

        $result = Board::find($board_id, [
            'id',
            'name',
            'description',
            'avatar_uri',
            'header_img_uri'
        ]);

        if ($result) {
            return ok($result);
        } else {
            return no(STATUS_NOT_FOUND);
        }
    }

    public function topics(Request $request)
    {
        $board_id = (int) $request->post('board');

        if ($board_id <= 0) {
            return no(STATUS_BAD_REQUEST);
        }

        $board = Board::find($board_id);

        if (!$board) {
            return no(STATUS_NOT_FOUND);
        }

        $result = $board->topics()
            ->limit(2)
            ->get(['id', 'author_id', 'board_id']);

        return ok($result);
    }
}
