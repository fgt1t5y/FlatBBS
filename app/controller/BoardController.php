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
        $response = $this->board->all($this->boardBasicFields);

        return $response->toJson();
    }

    public function info(Request $request, string $slug)
    {
        $response = $this->board->info($slug, $this->boardFields);

        return $response->getData();
    }

    public function search(Request $request)
    {
        $keyword = $request->post('q');

        $response = $this->search->search($keyword, Board::class, 'name');

        if (!$response->isSuccess()) {
            no(STATUS_INTERNAL_ERROR);
        }

        return $response->toJson();
    }
}
