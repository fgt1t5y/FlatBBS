<?php

namespace app\service;

use app\Model\Board;
use support\exception\NotFoundException;
use Illuminate\Database\RecordsNotFoundException;

class BoardService
{
    public function getAllBoards()
    {
        return Board::orderBy('id')->get();
    }

    public function getBoard(string $value)
    {
        try {
            return Board::where('slug', $value)->firstOrFail();
        } catch (RecordsNotFoundException $e) {
            throw new NotFoundException('$exception.board_not_found');
        }
    }

    public function getTopics(string $boardSlug, int $page, int $limit)
    {
        return $this->getBoard($boardSlug)
            ->first()
            ->topics()
            ->orderByDesc('last_reply_at')
            ->limit(min($limit, 50))
            ->offset(($page - 1) * $limit)
            ->get();
    }
}
