<?php

namespace app\controller;

use app\model\Board;
use app\service\SearchService;
use app\service\BoardService;
use support\Request;

class BoardController
{
    private $boardBasicFields = ['id', 'name', 'slug', 'avatar_uri'];
    private $boardFields = [
        'id',
        'name',
        'slug',
        'color',
        'description',
        'avatar_uri',
        'header_img_uri'
    ];

    protected SearchService $search;
    protected BoardService $board;

    public function __construct(SearchService $search, BoardService $board)
    {
        $this->search = $search;
        $this->board = $board;
    }

    public function all(Request $request)
    {
        $result = $this->board->all($this->boardBasicFields);

        return ok($result);
    }

    public function info(Request $request, string $slug)
    {
        $result = $this->board->info($slug, $this->boardFields);

        if (!$result) {
            return no(STATUS_NOT_FOUND);
        }

        return $result;
    }

    public function search(Request $request)
    {
        $keyword = $request->post('q');

        $result = $this->search->search($keyword, Board::class, 'name');

        return ok($result);
    }
}
