<?php

namespace app\controller;

use app\model\Board;
use app\model\Topic;
use app\service\SearchService;
use app\service\TopicService;
use DI\Attribute\Inject;
use support\Request;
use support\Gate;

class TopicController
{

    #[Inject]
    protected SearchService $search;
    #[Inject]
    protected TopicService $topic;

    public function all(Request $request)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');

        $result = $this->topic->all($last_id, $limit);

        return ok($result);
    }

    #[Gate('create:topic')]
    public function publish(Request $request)
    {
        $title = $request->post('title');
        $text = $request->post('text');
        $content = $request->post('content');
        $board_id = (int) $request->post('board_id');

        if (empty($title)) {
            return no(STATUS_BAD_REQUEST);
        }

        $author = $request->getUser();
        /** @var Board */
        $board = Board::find($board_id);

        $topic = $this->topic->build($title, $text, $content, $board, $author);
        $topic->save();

        $board->topic_count = $board->topic_count + 1;
        $board->save();

        return ok($topic);
    }

    public function detail(Request $request, int $topic_id)
    {
        $result = $this->topic->detail($topic_id);

        if (!$result) {
            return no(STATUS_NOT_FOUND);
        }

        return ok($result);
    }

    public function search(Request $request)
    {
        $keyword = $request->post('q');

        $result = $this->search->search($keyword, Topic::class, 'title');

        return ok($result);
    }
}
