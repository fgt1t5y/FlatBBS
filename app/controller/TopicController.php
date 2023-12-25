<?php

namespace app\controller;

use app\model\Board;
use app\model\Topic;
use support\Request;

class TopicController
{
    public $topicBasicFields = [
        'id',
        'title',
        'content',
        'author_id',
        'board_id',
        'reply_count',
        'created_at'
    ];

    public function all(Request $request)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');
        $result = Topic::orderByDesc('last_reply_at')
            ->limit(min($limit, 50))
            ->where('id', $last_id === 0 ? '>' : '<', $last_id)
            ->get($this->topicBasicFields);

        return ok($result);
    }

    public function list(Request $request, string $slug)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');
        $board = Board::where('slug', $slug)
            ->first();

        if (!$board) {
            return no(STATUS_NOT_FOUND);
        }

        $result = $board
            ->topics()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id)
            ->orderByDesc('last_reply_at')
            ->get($this->topicBasicFields);

        return ok($result);
    }

    public function create(Request $request)
    {
        $topic_title = $request->post('title');
        $topic_content = $request->post('content', '');
        $at_board = (int) $request->post('board', 0);
        $author_id = session('id');

        if (!all([$topic_title, $at_board])) {
            return no(STATUS_BAD_REQUEST);
        }

        $result_topic = Topic::createTopic(
            $topic_title,
            $topic_content,
            $at_board,
            $author_id,
        );
        if (!$result_topic) {
            no(STATUS_INTERNAL_ERROR);
        }

        return ok($result_topic);
    }

    public function search(Request $request)
    {
        $keyword = $request->post('q');
        $topics = search($keyword, Topic::class, 'title', $this->topicBasicFields);

        return ok($topics);
    }
}
