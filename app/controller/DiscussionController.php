<?php

namespace app\controller;

use app\service\DiscussionService;
use DI\Attribute\Inject;
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

    #[Inject]
    protected DiscussionService $discussion;

    public function list(Request $request, int $topic_id)
    {
        $last_id = (int) $request->post('last');
        $limit = (int) $request->post('limit');

        $result = $this->discussion->list($topic_id, $last_id, $limit, $this->discussionBasicFields);

        return ok($result);
    }
}
