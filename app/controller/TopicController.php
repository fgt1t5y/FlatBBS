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
        $last_id = (int) $request->post('last', 0);
        $limit = (int) $request->post('limit');
        $board = (int) $request->post('board');

        if ($limit > 20 || $last_id < 0) {
            return json_message(STATUS_BAD_REQUEST, '参数错误');
        }

        $builder = Topic::orderByDesc('created_at')
            ->limit(max($limit, 10))
            ->where('id', '>', $last_id);

        if ($board) {
            $builder = $builder->where('board_id', $board);
        }

        $result = $builder->get([
            'id',
            'title',
            'author_id',
            'board_id',
            'reply_count',
            'created_at'
        ]);

        return json_message(STATUS_OK, '完成', $result);
    }

    public function query(Request $request)
    {
        $keyword = $request->post('q');

        if (!all([$keyword])) {
            return json_message(STATUS_BAD_REQUEST, '参数错误');
        }

        try {
            $topics = Topic::whereRaw("MATCH(`title`) AGAINST(?)", [$keyword])->get();
        } catch (PDOException) {
            return json_message(STATUS_INTERNAL_ERROR, '内部错误');
        }

        return json_message(STATUS_OK, '完成', $topics);
    }

    public function discussions(Request $request)
    {
        $topic = (int) $request->post('topic');
        $discussions = Discussion::limit(10)
            ->where('topic_id', $topic)
            ->get([
                'id',
                'author_id',
                'content',
                'created_at'
            ]);

        if (!$discussions) {
            return json_message(STATUS_BAD_REQUEST, '话题不存在');
        }

        return json_message(STATUS_OK, '完成', $discussions);
    }
}
