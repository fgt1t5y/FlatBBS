<?php

namespace app\controller;

use app\model\Discussion;
use app\model\Topic;
use PDOException;
use support\Request;

class TopicController
{
    public function list(Request $request)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');
        $board_id = (int) $request->post('board');

        if ($last_id < 0) {
            return no(STATUS_BAD_REQUEST);
        }

        $builder = Topic::orderByDesc('last_reply_at')
            ->limit(min($limit, 50))
            ->where('id', $last_id === 0 ? '>' : '<', $last_id);

        if ($board_id != 0) {
            $builder = $builder->where('board_id', $board_id);
        }

        $result = $builder->get([
            'id',
            'title',
            'author_id',
            'board_id',
            'reply_count',
            'created_at'
        ]);

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

    public function discussions(Request $request)
    {
        $topic_id = (int) $request->post('topic');
        $topic = Topic::find($topic_id);

        if (!$topic) {
            return no(STATUS_NOT_FOUND);
        }

        $result = $topic->discussions()->limit(10)->get([
            'id',
            'author_id',
            'content',
            'created_at'
        ]);

        return ok($result);
    }
}
