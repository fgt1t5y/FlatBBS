<?php

namespace app\controller;

use support\Request;
use app\service\UserVisitLogService;
use DI\Attribute\Inject;

class MeController
{
    #[Inject]
    protected UserVisitLogService $userVisitLog;

    public function logs(Request $request)
    {
        $request->assertLogin();

        $last_id = $request->get('last');
        $limit = $request->get('limit');

        return ok($this->userVisitLog->getVisitLogs($request->getUser(), $last_id, $limit));
    }
}
