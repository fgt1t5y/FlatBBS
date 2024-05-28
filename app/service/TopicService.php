<?php

namespace app\service;

use app\model\Topic;
use app\model\Board;

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
}
