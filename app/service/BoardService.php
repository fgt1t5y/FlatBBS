<?php

namespace app\service;

use app\Model\Board;

class BoardService
{
    public function all(?array $columns = null)
    {
        $response = response();
        $result = Board::orderBy('id')->get($columns);

        return $response->setData($result)->success();
    }

    public function info(string $value, ?array $columns = null)
    {
        $response = response();
        $result = Board::where('slug', $value)
            ->first($columns);

        return $response->setData($result)->success();
    }
}
