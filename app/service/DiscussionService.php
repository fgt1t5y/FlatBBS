<?php

namespace app\service;

use app\model\Topic;

class DiscussionService
{
    public function list(int $id, int $last_id, int $limit, ?array $columns = null)
    {
        return Topic::find($id)
            ->discussions()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id)
            ->orderBy('created_at')
            ->get($columns);
    }
}
