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

    public function publish(Request $request, int $topicId)
    {
        $request->assertLogin();

        $content = $request->post('content');

        if (empty($content)) {
            return no(STATUS_BAD_REQUEST, '$exception.fill_out_form_completely');
        }

        $author = $request->getUser();
        /** @var Topic */
        $topic = Topic::find($topicId);

        $discussion = $this->discussion->build($content, $topic, $author);
        $discussion->save();

        $topic->discussion_count++;
        $topic->last_reply_at = Carbon::now();
        $topic->save();

        return ok(Discussion::find($discussion->id));
    }
}
