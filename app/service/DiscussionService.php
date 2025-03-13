<?php

namespace app\service;

use app\model\Topic;
use app\model\Discussion;
use app\model\User;
use support\exception\NotFoundException;
use Illuminate\Database\RecordsNotFoundException;

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

    public function getReplies(int $discussionId, int $page, int $limit)
    {
        return $this->getDiscussion($discussionId)->replies()
            ->orderBy('created_at')
            ->limit(min($limit, 50))
            ->offset(($page - 1) * $limit)
            ->get();
    }

    public function getDiscussion(int $discussionId)
    {
        try {
            return Discussion::findOrFail($discussionId);
        } catch (RecordsNotFoundException $e) {
            throw new NotFoundException('$exception.discussion_not_found');
        }
    }
}
