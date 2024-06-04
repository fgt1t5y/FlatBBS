<?php

namespace app\controller;

use DI\Attribute\Inject;
use support\Gate;
use support\Request;
use app\service\FileService;

class FileController
{
    #[Inject]
    protected FileService $file;

    #[Gate]
    public function upload(Request $request)
    {
        $result = $this->file->upload($request->file());

        if (!$result) {
            no(STATUS_INTERNAL_ERROR);
        }

        ok($result);
    }
}
