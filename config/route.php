<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;

Route::fallback(function () {
    return no(STATUS_NOT_FOUND, 'Route Not Found.');
});

Route::group('/board/{slug}', function () {
    // 获取论坛所有的版块
    Route::post('/all', [app\controller\BoardController::class, 'all']);
    // 通过 BoardID 获取指定版块的信息
    Route::post('/info', [app\controller\BoardController::class, 'info']);
});

Route::group('/topic/{slug}', function () {
    // 获取所有话题
    Route::post('/all', [app\controller\TopicController::class, 'all']);
    // 通过 BoardID 获取指定版块下的话题
    Route::post('/list', [app\controller\TopicController::class, 'list']);
});

Route::group('/discussion/{tid:\d+}', function () {
    // 通过 TopicID 获取指定话题下的讨论
    Route::post('/list', [app\controller\DiscussionController::class, 'list']);
});
