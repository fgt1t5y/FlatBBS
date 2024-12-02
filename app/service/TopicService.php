<?php

namespace app\service;

use app\model\Topic;
use app\model\Board;
use app\model\User;
use Carbon\Carbon;

class TopicService
{
    public function all(int $last_id, int $limit)
    {
        return Topic::orderByDesc('last_reply_at')
            ->limit(min($limit, 50))
            ->where('id', $last_id === 0 ? '>' : '<', $last_id)
            ->get();
    }

    public function create(string $title, string $content, Board $board, User $author)
    {
        $topic = new Topic;

        $topic->title = trim($title);
        $topic->content = $content ?? '<p></p>';
        $topic->board_id = $board->id;
        $topic->author_id = $author->id;
        $topic->last_reply_at = Carbon::now();

        return $topic;
    }

    public function detail(int $topic_id)
    {
        return Topic::where('id', $topic_id)->first();
    }
}
