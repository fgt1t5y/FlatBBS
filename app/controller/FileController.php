<?php

namespace app\controller;

use support\Request;
use Intervention\Image\ImageManagerStatic as image;

class FileController
{
  static $supportedFile = ['image/png'];

  public function index(Request $request)
  {
    var_dump($request->host());
    return view('test');
  }

  public function upload(Request $request)
  {
    $file = $request->file('avgfile');
    $filename = random_string() . '.jpg';

    if (!$file || !$file->isValid()) {
      return json_message(STATUS_BAD_REQUEST, '无效文件');
    }

    $image = image::make($file->getPathname());
    $image->save("public/usercontent/{$filename}", 60, 'jpg');

    return json_message(STATUS_OK, '完成');
  }
}
