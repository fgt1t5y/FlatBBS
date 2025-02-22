<?php

namespace app\service;

use app\model\User;

class UserVisitLogService
{
    public function getVisitLogs(User $user, int $last_id, int $limit, ?string $type)
    {
        $query = $user->visit_logs()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id);

        if ($type !== null) {
            $query->where('visitable_type', $type);
        }

        return $query->orderByDesc('updated_at')
            ->with(['visitable'])
            ->get();
    }
}
