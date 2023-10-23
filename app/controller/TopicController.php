<?php

namespace app\controller;

use app\model\Topic;
use support\Request;

class TopicController
{
    public function list(Request $request)
    {
        $_limit = (int) $request->post('limit');

        if ($_limit > 20) {
            return json_message(STATUS_BAD_REQUEST, '');
        }

        $topics = Topic::orderBy('created_at')
            ->limit(max($_limit, 10))
            ->with(['author:id,username', 'last_reply:id,username'])
            ->get(['id', 'title', 'author_id', 'last_reply_id', 'reply_count']);

        return json_message(0, '完成', $topics);
    }
}
