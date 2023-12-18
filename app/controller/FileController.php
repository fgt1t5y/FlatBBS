<?php

namespace app\controller;

use app\model\User;
use Intervention\Image\Exception\ImageException;
use support\Request;
use Intervention\Image\ImageManagerStatic as image;

class FileController
{
    static $supportedFile = ['image/png', 'image/jpeg'];

    public function upload(Request $request)
    {
        $files = $request->file('avgfile');
        $as = $request->post('as');
        $filepath = [];
        $filename = '';

        if (!$files) {
            return no(STATUS_BAD_REQUEST);
        }

        // 单个文件时 file 是 object，将其转换为 array 才可以 foreach
        if (is_object($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if (!in_array($file->getUploadMimeType(), self::$supportedFile)) {
                return no(STATUS_BAD_REQUEST);
            }

            $filename = random_string() . '.jpg';
            $path = config_with('flatbbs.paths.usercontent', $filename);

            try {
                $image = image::make($file->getPathname());
                $image->save($path, 60, 'jpg');
            } catch (ImageException) {
                return no(STATUS_BAD_REQUEST);
            }
            array_push($filepath, $filename);

            if ($as !== 'attachment') {
                User::modifyUser(
                    session('id'),
                    'avatar_uri',
                    $filename
                );

                break;
            }
        }

        return ok([
            'uri' => count($filepath) > 1 ? $filepath : $filename
        ]);
    }
}
