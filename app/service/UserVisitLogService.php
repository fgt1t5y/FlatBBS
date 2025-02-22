<?php

namespace app\service;

use app\model\User;

class UserVisitLogService
{
    public function getVisitLogs(User $user, int $last_id, int $limit)
    {
        return $user->visit_logs()
            ->limit(min($limit, 50))
            ->where('id', '>', $last_id)
            ->orderBy('updated_at', 'dasc')
            ->with(['visitable'])
            ->get();
    }
}
