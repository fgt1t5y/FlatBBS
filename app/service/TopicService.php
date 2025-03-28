<?php

namespace app\service;

use app\model\Topic;
use app\model\Board;
use app\model\User;
use support\exception\NotFoundException;
use Carbon\Carbon;
use Illuminate\Database\RecordsNotFoundException;

class TopicService
{
    public function getAllTopics(int $lastId, int $limit)
    {
        return Topic::orderByDesc('created_at')
            ->limit(min($limit, 50))
            ->where('id', $lastId === 0 ? '>' : '<', $lastId)
            ->get(['id', 'board_id', 'discussion_count', 'like_count', 'author_id', 'title', 'text', 'created_at']);
    }

    public function getDiscussions(int $topicId, int $page, int $limit)
    {
        return $this->getTopic($topicId)
            ->discussions()
            ->orderBy('updated_at')
            ->limit(min($limit, 50))
            ->offset(($page - 1) * $limit)
            ->get();
    }

    public function build(string $title, string $text, string $content, Board $board, User $author)
    {
        $topic = new Topic;

        $topic->title = trim($title);
        $topic->text = trim($text);
        $topic->content = $content ?? '<p></p>';
        $topic->board_id = $board->id;
        $topic->author_id = $author->id;
        $topic->last_reply_at = Carbon::now();

        return $topic;
    }

    public function getTopic(int $topicId)
    {
        try {
            return Topic::findOrFail($topicId);
        } catch (RecordsNotFoundException $e) {
            throw new NotFoundException('$exception.topic_not_found');
        }
    }

    public function toggleLike(int $topicId, int $userId): int
    {
        $topic = Topic::find($topicId);

        if (!$topic) {
            return -1;
        }

        $is_liked = $topic->likes()->where('user_id', $userId)->exists();

        if ($is_liked) {
            $topic->likes()->detach($userId);
            $topic->like_count--;
            $topic->save();
        } else {
            $topic->likes()->attach($userId);
            $topic->like_count++;
            $topic->save();
        }

        return $topic->like_count;
    }
}
