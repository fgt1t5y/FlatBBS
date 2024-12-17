<?php

namespace app\service;

use app\Model\Board;

class BoardService
{
    public function all(?array $columns = null)
    {
        return Board::orderBy('id')->get($columns);
    }

    public function hotspot(?array $columns = null)
    {
        return Board::orderBy('topic_count')->limit(10)->get($columns);
    }

    public function info(string $value, ?array $columns = null)
    {
        return Board::where('slug', $value)->first($columns);
    }

    public function topics(string $slug, int $last_id, int $limit)
    {
        return Board::where('slug', $slug)
            ->firstOrFail()
            ->topics()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id)
            ->orderByDesc('last_reply_at')
            ->get();
    }
}
