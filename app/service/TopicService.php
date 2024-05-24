<?php

namespace app\service;

use app\model\Topic;
use app\model\Board;

class TopicService
{
    public function all(int $last_id, int $limit, ?array $columns = null)
    {
        $response = response();

        $result = Topic::orderByDesc('last_reply_at')
            ->limit(min($limit, 50))
            ->where('id', $last_id === 0 ? '>' : '<', $last_id)
            ->get($columns);

        return $response->setData($result)->success();
    }

    public function list(string $slug, int $last_id, int $limit, ?array $columns = null)
    {
        $response = response();

        $result = Board::where('slug', $slug)
            ->firstOrFail()
            ->topics()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id)
            ->orderByDesc('last_reply_at')
            ->get($columns);

        return $response->setData($result)->success();
    }
}
