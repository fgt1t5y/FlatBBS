<?php

namespace app\controller;

use app\service\DiscussionService;
use DI\Attribute\Inject;
use support\Request;
use app\model\Topic;

class DiscussionController
{
    #[Inject]
    protected DiscussionService $discussion;

    public function list(Request $request, int $topic_id)
    {
        $last_id = $request->get('last');
        $limit = $request->get('limit');

        $result = $this->discussion->list($topic_id, $last_id, $limit);

        return ok($result);
    }

    public function publish(Request $request, int $topic_id)
    {
        $request->assertLogin();

        $content = $request->post('content');

        if (empty($content)) {
            return no(STATUS_BAD_REQUEST, 'i18n$exception.fill_out_form_completely');
        }

        $author = $request->getUser();
        /** @var Topic */
        $topic = Topic::find($topic_id);

        $discussion = $this->discussion->build($content, $topic, $author);
        $discussion->save();

        // DOTO: add `discussion_count` column to Topic model;

        return ok($discussion);
    }
}
