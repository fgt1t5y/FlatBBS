<?php

namespace app\controller;

use app\model\Board;
use app\model\Discussion;
use app\model\Topic;
use DateTime;
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
            return json_message(STATUS_BAD_REQUEST, '参数错误');
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

        return json_message(STATUS_OK, '完成', $result);
    }

    public function create(Request $request)
    {
        $topic_title = $request->post('title');
        $topic_content = $request->post('content', '');
        // $topic_attach = $request->post('attachment', '');
        $at_board = (int) $request->post('board', 0);
        $author_id = session('id');

        if (!all([$topic_title, $at_board])) {
            return json_message(STATUS_BAD_REQUEST, '参数错误');
        }

        $result_topic = Topic::createTopic(
            $topic_title,
            $topic_content,
            $at_board,
            $author_id,
        );
        if (!$result_topic) {
            json_message(STATUS_OK, '创建话题失败');
        }

        return json_message(STATUS_OK, '完成', $result_topic);
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
