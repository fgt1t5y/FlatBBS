<?php

namespace app\service;

use app\model\Topic;
use app\model\Discussion;

class DiscussionService
{
    public function list(int $id, int $last_id, int $limit, ?array $columns = null)
    {
        $response = response();

        $result = Topic::find($id)
            ->discussions()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id)
            ->orderBy('created_at')
            ->get($columns);

        return $response->setData($result);
    }
}
