<?php

namespace app\controller;

use app\service\DiscussionService;
use support\Request;

class DiscussionController
{
    private $discussionBasicFields = [
        'id',
        'topic_id',
        'author_id',
        'content',
        'created_at'
    ];

    protected DiscussionService $discussion;

    public function __construct(DiscussionService $discussion)
    {
        $this->discussion = $discussion;
    }

    public function list(Request $request, int $topic_id)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');

        $response = $this->discussion->list($topic_id, $last_id, $limit, $this->discussionBasicFields);

        return $response->toJson();
    }
}
