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

    public function publish(Request $request, int $boardId)
    {
        $request->assertLogin();

        $title = $request->post('title');
        $text = $request->post('text');
        $content = $request->post('content');

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

        $author->topic_count++;
        $author->save();

        return ok($topic);
    }

    public function detail(Request $request, int $topicId)
    {
        $topic = $this->topic->getTopic($topicId);

        if ($request->isLoggined()) {
            $this->visitLog->pushVisitLog($request->getUser(), $topic);
        }

        return ok($topic);
    }

    public function like(Request $request, int $topicId)
    {
        $request->assertLogin();

        $userId = session('id');

        return ok(
            $this->topic->toggleLike($topicId, $userId)
        );
    }

    public function edit(Request $request, int $topicId)
    {
        $request->assertLogin();

        $title = $request->post('title');
        $text = $request->post('text');
        $content = $request->post('content');
        $topic = $this->topic->getTopic($topicId);

        $topic->setAttribute('title', $title);
        $topic->setAttribute('text', $text);
        $topic->setAttribute('content', $content);

        if ($topic->isDirty()) {
            return ok($topic->save());
        } else {
            return ok(true);
        }
    }
}
