<?php

namespace app\controller;

use app\model\Topic;
use support\Request;

class TopicController
{
    public function list(Request $request)
    {
        $last_id = (int) $request->post('last', 0);
        $_limit = (int) $request->post('limit');
        $board = (int) $request->post('board');

        if ($_limit > 20 || $last_id < 0) {
            return json_message(STATUS_BAD_REQUEST, '参数错误');
        }

        $builder = Topic::orderBy('last_reply_at')
            ->limit(max($_limit, 10))
            ->with([
                'author:id,username',
                'board:id,name,color',
            ])
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
            'last_reply_at'
        ]);

        return json_message(STATUS_OK, '完成', $result);
    }
}
