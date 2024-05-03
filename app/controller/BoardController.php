<?php

namespace app\controller;

use app\model\Board;
use support\Request;
use app\service\Search;

class BoardController
{
    public $boardBasicFields = ['id', 'name', 'slug', 'avatar_uri'];
    public $boardFields = [
        'id',
        'name',
        'slug',
        'color',
        'description',
        'avatar_uri',
        'header_img_uri'
    ];

    public function all(Request $request)
    {
        $result = Board::orderByDesc('id')
            ->get($this->boardBasicFields);

        return ok($result);
    }

    public function info(Request $request, string $slug)
    {
        $result = Board::where('slug', $slug)
            ->first($this->boardFields);

        return $result ? $result : no(STATUS_NOT_FOUND);
    }

    public function search(Request $request)
    {
        $keyword = $request->post('q');

        return ok(Search::board($keyword, $this->boardFields));
    }
}
