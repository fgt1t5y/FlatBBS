<?php

namespace app\controller;

use Intervention\Image\Exception\NotReadableException;
use support\Request;
use Intervention\Image\ImageManagerStatic as image;

class FileController
{
  static $supportedFile = ['image/png', 'image/jpeg'];

  public function index(Request $request)
  {
    var_dump($request->host());
    return view('test');
  }

  public function upload(Request $request)
  {
    $file = $request->file('avgfile');

    if (
      !$file
      || !$file->isValid()
      || !in_array($file->getUploadMimeType(), self::$supportedFile)
    ) {
      return json_message(STATUS_BAD_REQUEST, '无效文件');
    }

    $filename = random_string() . '.jpg';

    try {
      $image = image::make($file->getPathname());
    } catch (NotReadableException $e) {
      return json_message(STATUS_BAD_REQUEST, '损坏的文件');
    }
    $image->save("public/usercontent/{$filename}", 60, 'jpg');

    return json_message(STATUS_OK, '完成');
  }
}
