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
    // 通过 BoardID 获取指定版块的信息
    Route::get('/info', [app\controller\BoardController::class, 'info']);
    // 通过 BoardID 获取指定版块下的话题
    Route::get('/topics', [app\controller\BoardController::class, 'topics']);
});

Route::group('/topic/{tid:\d+}', function () {
    Route::get('/detail', [app\controller\TopicController::class, 'detail']);
});

Route::group('/discussion/{tid:\d+}', function () {
    // 通过 TopicID 获取指定话题下的讨论
    Route::get('/list', [app\controller\DiscussionController::class, 'list']);
});
