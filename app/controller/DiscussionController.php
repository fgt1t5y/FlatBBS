<?php

namespace app\controller;

use app\model\Topic;
use support\Request;

class DiscussionController
{
    public $discussionBasicFields = [
        'id',
        'author_id',
        'content',
        'created_at'
    ];

    public function list(Request $request, int $tid)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');
        $topic = Topic::find($tid, ['title', 'id']);

        if (!$topic) {
            return no(STATUS_NOT_FOUND);
        }

        $result = $topic
            ->discussions()
            ->limit(min($limit, 50))
            ->where('id', $last_id === 0 ? '>' : '<', $last_id)
            ->orderBy('created_at')
            ->get($this->discussionBasicFields);

        return ok($result, $topic);
    }
}
