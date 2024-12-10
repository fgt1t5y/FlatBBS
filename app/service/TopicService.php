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
            ->get(['id', 'board_id', 'author_id', 'title', 'text', 'created_at']);
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

    public function detail(int $topic_id)
    {
        return Topic::where('id', $topic_id)
            ->first(['id', 'board_id', 'author_id', 'title', 'content', 'created_at']);
    }
}
