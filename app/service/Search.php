<?php

namespace app\service;

use Log;
use app\model\Topic;
use app\model\Board;

class Search
{
    public static function base(string $keyword, string $model, string $by, array $columns)
    {
        if ($keyword == '' || $columns == [])
            return null;
        try {
            return $model::whereRaw("MATCH(`$by`) AGAINST(?)", [$keyword])->get($columns);
        } catch (\PDOException $e) {
            Log::channel('app.search')->error($e->getMessage());
            return null;
        }
    }

    public static function board(string $keyword, array $columns)
    {
        return self::base($keyword, Board::class, 'name', $columns);
    }

    public static function topic(string $keyword, array $columns)
    {
        return self::base($keyword, Topic::class, 'title', $columns);
    }
}
