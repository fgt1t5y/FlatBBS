<?php

namespace app\controller;

use app\service\BoardService;
use DI\Attribute\Inject;
use support\Request;

class BoardController
{
    private $board_basic_fields = ['id', 'name', 'slug', 'avatar_uri'];
    private $board_fields = [
        'id',
        'name',
        'slug',
        'topic_count',
        'description',
        'avatar_uri',
    ];

    #[Inject]
    protected BoardService $board;

    public function all(Request $request)
    {
        $result = $this->board->getAllBoards($this->board_basic_fields);

        return ok($result);
    }

    public function info(Request $request, string $slug)
    {
        $result = $this->board->getBoardInfo($slug, $this->board_fields);

        if (!$result) {
            return no(STATUS_NOT_FOUND, '$exception.board_not_found');
        }

        return ok($result);
    }

    public function topics(Request $request, string $slug)
    {
        $page = $request->get('page');
        $limit = $request->get('limit');

        $result = $this->board->getTopicsBySlug($slug, $page, $limit);

        return ok($result);
    }
}
