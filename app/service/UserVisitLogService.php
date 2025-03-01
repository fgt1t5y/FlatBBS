<?php

namespace app\service;

use app\model\User;
use app\model\UserVisitLog;
use support\VisitableModel;
use support\Model;
use Carbon\Carbon;

class UserVisitLogService
{
    public function getVisitLogs(User $user, int $page, int $limit)
    {
        return UserVisitLog::orderByDesc('updated_at')
            ->where('user_id', $user->id)
            ->limit(min($limit, 50))
            ->offset(($page - 1) * $limit)
            ->get();
    }

    public function pushVisitLog(User $user, VisitableModel|Model $visitable): bool
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
