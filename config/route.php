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


// API routes
Route::get('/boards', [app\controller\BoardController::class, 'all']);
Route::get('/topics', [app\controller\TopicController::class, 'all']);

Route::group('/auth', function () {
    Route::post('/login', [app\controller\AuthController::class, 'login']);
    Route::post('/logout', [app\controller\AuthController::class, 'logout']);
    Route::post('/forget', [app\controller\AuthController::class, 'forget']);
});

Route::group('/board/{boardSlug}', function () {
    Route::get('/detail', [app\controller\BoardController::class, 'detail']);
    Route::get('/topics', [app\controller\BoardController::class, 'topics']);
});

Route::post('/discussion/publish', [app\controller\DiscussionController::class, 'publish']);

Route::group('/discussion/{discussionId:\d+}', function () {
    Route::get('/replies', [app\controller\DiscussionController::class, 'replies']);
});

Route::group('/file', function () {
    Route::put('/image', [app\controller\FileController::class, 'image']);
});

Route::group('/me', function () {
    Route::get('/logs', [app\controller\MeController::class, 'logs']);
    Route::get('/info', [app\controller\MeController::class, 'info']);
    Route::post('/info', [app\controller\MeController::class, 'modify']);
    Route::post('/avatar', [app\controller\MeController::class, 'avatar']);
    Route::post('/password', [app\controller\MeController::class, 'password']);
});

Route::post('/topic/publish', [app\controller\TopicController::class, 'publish']);

Route::group('/topic/{topicId:\d+}', function () {
    Route::get('/detail', [app\controller\TopicController::class, 'detail']);
    Route::get('/discussions', [app\controller\TopicController::class, 'discussions']);
    Route::post('/like', [app\controller\TopicController::class, 'like']);
    Route::post('/edit', [app\controller\TopicController::class, 'edit']);
});

Route::group('/user/{username}', function () {
    Route::get('/info', [app\controller\UserController::class, 'info']);
    Route::get('/topics', [app\controller\UserController::class, 'topics']);
    Route::get('/liked', [app\controller\UserController::class, 'liked']);
});

// Fallback Route
Route::fallback(function () {
    return no(STATUS_NOT_FOUND, 'Route Not Found.');
});

// Disable auto route
Route::disableDefaultRoute();
