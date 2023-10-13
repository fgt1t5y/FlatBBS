<?php

namespace app\controller;

use app\model\User;
use Intervention\Image\Exception\NotReadableException;
use support\Request;
use Intervention\Image\ImageManagerStatic as image;

class FileController
{
  static $supportedFile = ['image/png', 'image/jpeg'];

  public function index(Request $request)
  {
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
    $path = "public/usercontent/{$filename}";
    $as = $request->post('as');
    $full_path = config('flatbbs.backend.path') . $path;

    try {
      $image = image::make($file->getPathname());
    } catch (NotReadableException) {
      return json_message(STATUS_BAD_REQUEST, '损坏的文件');
    }
    $image->save($path, 60, 'jpg');

    if ($as === 'avatar') {
      User::modifyUser(
        $request->session()->get('id'),
        'avatar_uri',
        $filename
      );
    }

    return json_message(STATUS_OK, '完成', [
      'uri' => $full_path
    ]);
  }
}
