<?php

namespace app\controller;

use support\Request;
use app\service\FileService;

class FileController
{
    protected FileService $file;
    public function __construct(FileService $file)
    {
        $this->file = $file;
    }

    public function upload(Request $request)
    {
        return $this->file->upload($request->file());
    }
}
