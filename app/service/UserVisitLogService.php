<?php

namespace app\service;

use app\model\User;
use app\model\UserVisitLog;
use support\VisitableModel;
use Carbon\Carbon;

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

    public function pushVisitLog(User $user, VisitableModel $visitable)
    {
        $oldVisitLog = UserVisitLog::where('user_id', $user->id)
            ->where('visitable_id', $visitable->getVisitableId())
            ->where('visitable_type', $visitable->getVisitableType())
            ->first();

        if (!$oldVisitLog) {
            $visitableLog = new UserVisitLog;

            $visitableLog->user_id = $user->id;
            $visitableLog->visitable_id = $visitable->getVisitableId();
            $visitableLog->visitable_type = $visitable->getVisitableType();

            return $visitableLog->save();
        } else {
            $oldVisitLog->updated_at = Carbon::now();

            return $oldVisitLog->save();
        }
    }
}
