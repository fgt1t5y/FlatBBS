<?php

namespace app\controller;

use app\model\Board;
use app\model\Topic;
use PDOException;
use support\Request;

class TopicController
{
    public $topicBasicFields = [
        'id',
        'title',
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

    public function list(Request $request, int $bid)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');
        $board = Board::find($bid);

        if (!$board) {
            return no(STATUS_NOT_FOUND);
        }

        $result = $board
            ->topics()
            ->limit(min($limit, 50))
            ->where('id', $last_id === 0 ? '>' : '<', $last_id)
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

        if (!all([$topic_title, $at_board, $topic_content])) {
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

    public function query(Request $request)
    {
        $keyword = $request->post('q');

        if (!all([$keyword])) {
            return no(STATUS_BAD_REQUEST);
        }

        try {
            $topics = Topic::whereRaw("MATCH(`title`) AGAINST(?)", [$keyword])->get();
        } catch (PDOException) {
            return no(STATUS_INTERNAL_ERROR);
        }

        return ok($topics);
    }
}
