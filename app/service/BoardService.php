<?php

namespace app\service;

use app\Model\Board;

class BoardService
{
    public function all(?array $columns = null)
    {
        return Board::orderBy('id')->get($columns);
    }

    public function info(string $value, ?array $columns = null)
    {
        return Board::where('slug', $value)->first($columns);
    }
}
