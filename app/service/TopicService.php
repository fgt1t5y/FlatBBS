<?php

namespace app\service;

use app\model\Topic;
use app\model\Board;
use app\model\User;
use Carbon\Carbon;

class TopicService
{
    public function all(int $last_id, int $limit, ?array $columns = null)
    {
        return Topic::orderByDesc('last_reply_at')
            ->limit(min($limit, 50))
            ->where('id', $last_id === 0 ? '>' : '<', $last_id)
            ->get($columns);
    }

    public function list(string $slug, int $last_id, int $limit, ?array $columns = null)
    {
        return Board::where('slug', $slug)
            ->firstOrFail()
            ->topics()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id)
            ->orderByDesc('last_reply_at')
            ->get($columns);
    }

    public function create(string $title, Board $board, User $author)
    {
        $topic = new Topic;

        $topic->title = trim($title);
        $topic->board_id = $board->id;
        $topic->author_id = $author->id;
        $topic->last_reply_at = Carbon::now();

        return $topic;
    }
}
