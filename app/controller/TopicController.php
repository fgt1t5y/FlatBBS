<?php

namespace app\controller;

use app\model\Topic;
use support\Request;

class TopicController
{
    public function topics(Request $request)
    {
        $topics = Topic::orderBy('created_at')
            ->limit(10)
            ->with('author:id,username')
            ->get();

        return json_message(0, '完成', $topics);
    }
}
