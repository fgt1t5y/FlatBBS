<?php

namespace app\service;

use app\Model\Board;

class BoardService
{
    public function getAllBoards()
    {
        return Board::orderBy('id')->get();
    }

    public function getBoardInfo(string $value)
    {
        return Board::where('slug', $value)->first();
    }

    public function getTopics(string $boardSlug, int $page, int $limit)
    {
        return Board::where('slug', $boardSlug)
            ->first()
            ->topics()
            ->orderByDesc('last_reply_at')
            ->limit(min($limit, 50))
            ->offset(($page - 1) * $limit)
            ->get();
    }
}
