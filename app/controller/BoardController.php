<?php

namespace app\controller;

use app\model\Board;
use support\Request;
use Shopwwi\LaravelCache\Cache;

class BoardController
{
    public $boardBasicFields = ['id', 'name', 'color'];
    public $boardFields = [
        'id',
        'name',
        'description',
        'avatar_uri',
        'header_img_uri'
    ];

    public function all(Request $request)
    {
        $boards = Cache::remember('all_boards', config('flatbbs.cache.ttl'), function () {
            return Board::orderByDesc('id')->get($this->boardBasicFields)->toArray();
        });

        return ok($boards);
    }

    public function info(Request $request, int $bid)
    {
        $result = Board::find($bid, $this->boardFields);

        if (!$result) {
            return no(STATUS_NOT_FOUND);
        }

        return ok($result);
    }

    public function search(Request $request)
    {
        $keyword = $request->post('q');
        $boards = search($keyword, Board::class, 'name', $this->boardFields);

        return ok($boards);
    }
}
