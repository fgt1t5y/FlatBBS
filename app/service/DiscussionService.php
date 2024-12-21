<?php

namespace app\service;

use app\model\Topic;
use app\model\Discussion;
use app\model\User;

class DiscussionService
{
    public function list(int $id, int $last_id, int $limit)
    {
        return Topic::find($id)
            ->discussions()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id)
            ->orderBy('created_at')
            ->get();
    }

    public function build(string $content, Topic $topic, User $author)
    {
        $discussion = new Discussion;

        $discussion->content = $content;
        $discussion->topic_id = $topic->id;
        $discussion->author_id = $author->id;

        return $discussion;
    }
}
