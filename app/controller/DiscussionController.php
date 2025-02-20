<?php

namespace app\controller;

use app\model\Discussion;
use app\service\DiscussionService;
use Carbon\Carbon;
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

        $result = $this->discussion->getDiscussionsByTopicId($topic_id, $last_id, $limit);

        return ok($result);
    }

    public function publish(Request $request, int $topic_id)
    {
        $request->assertLogin();

        $content = $request->post('content');

        if (empty($content)) {
            return no(STATUS_BAD_REQUEST, '$exception.fill_out_form_completely');
        }

        $author = $request->getUser();
        /** @var Topic */
        $topic = Topic::find($topic_id);

        $discussion = $this->discussion->build($content, $topic, $author);
        $discussion->save();

        $topic->discussion_count++;
        $topic->last_reply_at = Carbon::now();
        $topic->save();

        return ok(Discussion::find($discussion->id));
    }
}
