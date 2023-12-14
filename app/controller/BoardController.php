<?php

namespace app\controller;

use app\model\Board;
use support\Request;
use Shopwwi\LaravelCache\Cache;

class BoardController
{
    public function all(Request $request)
    {
        $boards = Cache::remember('all_boards', config('flatbbs.cache.ttl'), function () {
            return Board::orderByDesc('id')->get(['id', 'name', 'color'])->toArray();
        });

        return ok($boards);
    }

    public function info(Request $request, int $bid)
    {
        $result = Board::find($bid, [
            'id',
            'name',
            'description',
            'avatar_uri',
            'header_img_uri'
        ]);

        if (!$result) {
            return no(STATUS_NOT_FOUND);
        }

        return ok($result);
    }
}
