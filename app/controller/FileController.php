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

        // 单个文件时 file 是 object，将其转换为 array 才可以 foreach
        if (is_object($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if (
                !$file
                || !$file->isValid()
                || !in_array($file->getUploadMimeType(), self::$supportedFile)
            ) {
                return json_message(STATUS_BAD_REQUEST, '无效文件 ' . $file->getUploadName());
            }

            $filename = random_string() . '.jpg';
            $path = config_with('flatbbs.backend_path.usercontent', $filename);

            try {
                $image = image::make($file->getPathname());
                $image->save($path, 60, 'jpg');
            } catch (ImageException) {
                return json_message(STATUS_BAD_REQUEST, '保存失败');
            }
            array_push($filepath, $filename);

            if ($as === 'avatar') {
                User::modifyUser(
                    $request->session()->get('id'),
                    'avatar_uri',
                    $filename
                );

                break;
            }
        }

        return json_message(STATUS_OK, '完成', [
            'uri' => count($filepath) > 1 ? $filepath : $filename
        ]);
    }
}
