<?php

namespace app\controller;

use app\model\Board;
use app\service\SearchService;
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
    protected SearchService $search;
    #[Inject]
    protected BoardService $board;

    public function all(Request $request)
    {
        $result = $this->board->all($this->board_basic_fields);

        return ok($result);
    }

    public function hotspot(Request $request)
    {
        $result = $this->board->hotspot($this->board_basic_fields);

        return ok($result);
    }

    public function info(Request $request, string $slug)
    {
        $result = $this->board->info($slug, $this->board_fields);

        if (!$result) {
            return no(STATUS_NOT_FOUND, 'i18n$exception.board_not_found');
        }

        return ok($result);
    }

    public function topics(Request $request, string $slug)
    {
        $last_id = $request->get('last');
        $limit = $request->get('limit');

        $result = $this->board->topics($slug, $last_id, $limit);

        return ok($result);
    }

    public function search(Request $request)
    {
        $keyword = $request->post('q');

        $result = $this->search->search($keyword, Board::class, 'name');

        return ok($result);
    }
}
