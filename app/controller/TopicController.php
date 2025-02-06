<?php

namespace app\controller;

use app\model\Board;
use app\service\TopicService;
use DI\Attribute\Inject;
use support\Request;

class TopicController
{
    #[Inject]
    protected TopicService $topic;

    public function all(Request $request)
    {
        $last_id = $request->get('last');
        $limit = $request->get('limit');

        $result = $this->topic->getAllTopics($last_id, $limit);

        return ok($result);
    }

    public function publish(Request $request)
    {
        $request->assertLogin();

        $title = $request->post('title');
        $text = $request->post('text');
        $content = $request->post('content');
        $board_id = (int) $request->post('board_id');

        if (empty($title)) {
            return no(STATUS_BAD_REQUEST, '{{exception.fill_out_form_completely}}');
        }

        $author = $request->getUser();
        /** @var Board */
        $board = Board::find($board_id);

        $topic = $this->topic->build($title, $text, $content, $board, $author);
        $topic->save();

        $board->topic_count++;
        $board->save();

        return ok($topic);
    }

    public function detail(Request $request, int $topic_id)
    {
        $result = $this->topic->getTopicDetail($topic_id);

        if (!$result) {
            return no(STATUS_NOT_FOUND, '{{exception.topic_not_found}}');
        }

        return ok($result);
    }

    public function like(Request $request, int $topic_id)
    {
        $request->assertLogin();

        $user_id = session('id');

        $like_count = $this->topic->toggleLike($topic_id, $user_id);

        return ok($like_count);
    }
}
