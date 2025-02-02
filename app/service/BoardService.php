<?php

namespace app\service;

use app\Model\Board;

class BoardService
{
    public function getAllBoards(?array $columns = null)
    {
        return Board::orderBy('id')->get($columns);
    }

    public function getHotBoards(?array $columns = null)
    {
        return Board::orderByDesc('topic_count')->limit(10)->get($columns);
    }

    public function getBoardInfo(string $value, ?array $columns = null)
    {
        return Board::where('slug', $value)->first($columns);
    }

    public function getTopicsByBoardSlug(string $slug, int $last_id, int $limit)
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
