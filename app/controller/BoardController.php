<?php

namespace app\controller;

use app\model\Board;
use support\Request;

class BoardController
{
    public $boardBasicFields = ['id', 'name', 'slug', 'color'];
    public $boardFields = [
        'id',
        'name',
        'slug',
        'description',
        'avatar_uri',
        'header_img_uri'
    ];

    public function all(Request $request)
    {
        $result = Board::orderByDesc('id')->get($this->boardBasicFields);

        return ok($result);
    }

    public function info(Request $request, string $bslug)
    {
        $result = Board::find($bslug, $this->boardFields);

        return $result ? ok($result) : no(STATUS_NOT_FOUND);
    }

    public function search(Request $request)
    {
        $keyword = $request->post('q');
        $boards = search($keyword, Board::class, 'name', $this->boardFields);

        return ok($boards);
    }
}
