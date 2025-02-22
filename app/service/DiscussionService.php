<?php

namespace app\service;

use app\model\Topic;
use app\model\Discussion;
use app\model\User;

class DiscussionService
{
    public function build(string $content, Topic $topic, User $author)
    {
        $discussion = new Discussion;

        $discussion->content = $content;
        $discussion->topic_id = $topic->id;
        $discussion->author_id = $author->id;

        return $discussion;
    }
}
