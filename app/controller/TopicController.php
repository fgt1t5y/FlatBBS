<?php

namespace app\controller;

use app\model\Board;
use app\service\TopicService;
use app\service\UserVisitLogService;
use DI\Attribute\Inject;
use support\Request;

class TopicController
{
    #[Inject]
    protected TopicService $topic;

    #[Inject]
    protected UserVisitLogService $visitLog;

    public function all(int $last, int $limit)
    {
        return ok(
            $this->topic->getAllTopics($last, $limit)
        );
    }

    public function discussions(int $topicId, int $page, int $limit)
    {
        return ok(
            $this->topic->getDiscussions($topicId, $page, $limit)
        );
    }

    public function publish(Request $request)
    {
        $request->assertLogin();

        $title = $request->post('title');
        $text = $request->post('text');
        $content = $request->post('content');
        $boardId = (int) $request->post('board_id');

        if (empty($title)) {
            return no(STATUS_BAD_REQUEST, '$exception.fill_out_form_completely');
        }

        $author = $request->getUser();
        /** @var Board */
        $board = Board::find($boardId);

        $topic = $this->topic->build($title, $text, $content, $board, $author);
        $topic->save();

        $board->topic_count++;
        $board->save();

        return ok($topic);
    }

    public function detail(Request $request, int $topicId)
    {
        $result = $this->topic->getTopicDetail($topicId);

        if ($request->isLoggined()) {
            $this->visitLog->pushVisitLog($request->getUser(), $result);
        }

        if (!$result) {
            return no(STATUS_NOT_FOUND, '$exception.topic_not_found');
        }

        return ok($result);
    }

    public function like(Request $request, int $topicId)
    {
        $request->assertLogin();

        $userId = session('id');

        return ok(
            $this->topic->toggleLike($topicId, $userId)
        );
    }
}
