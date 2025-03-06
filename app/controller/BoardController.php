<?php

namespace app\controller;

use app\service\BoardService;
use DI\Attribute\Inject;
use support\Request;

class BoardController
{
    #[Inject]
    protected BoardService $board;

    public function all(Request $request)
    {
        return ok($this->board->getAllBoards());
    }

    public function info(Request $request, string $slug)
    {
        $result = $this->board->getBoardInfo($slug);

        if (!$result) {
            return no(STATUS_NOT_FOUND, '$exception.board_not_found');
        }

        return ok($result);
    }

    public function topics(Request $request, string $slug)
    {
        $page = $request->get('page');
        $limit = $request->get('limit');

        return ok(
            $this->board->getTopics($slug, $page, $limit)
        );
    }
}
