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

Route::group('/auth', function () {
    Route::post('/login', [app\controller\AuthController::class, 'login']);
    Route::post('/logout', [app\controller\AuthController::class, 'logout']);
    Route::post('/forget', [app\controller\AuthController::class, 'forget']);
});

Route::group('/boards', function () {
    Route::get('/all', [app\controller\BoardController::class, 'all']);
    Route::get('/hotspot', [app\controller\BoardController::class, 'hotspot']);
});

Route::group('/board/{slug}', function () {
    Route::get('/info', [app\controller\BoardController::class, 'info']);
    Route::get('/topics', [app\controller\BoardController::class, 'topics']);
});

Route::group('/discussion/{tid:\d+}', function () {
    Route::get('/list', [app\controller\DiscussionController::class, 'list']);
    Route::post('/publish', [app\controller\DiscussionController::class, 'publish']);
});

Route::group('/file', function () {
    Route::post('/upload', [app\controller\FileController::class, 'upload']);
});

Route::group('/topics', function () {
    Route::get('/all', [app\controller\TopicController::class, 'all']);
    Route::post('/publish', [app\controller\TopicController::class, 'publish']);
});

Route::group('/topic/{tid:\d+}', function () {
    Route::get('/detail', [app\controller\TopicController::class, 'detail']);
    Route::post('/like', [app\controller\TopicController::class, 'like']);
});

Route::group('/user', function () {
    Route::get('/me', [app\controller\UserController::class, 'me']);
    Route::post('/me', [app\controller\UserController::class, 'modifyMe']);
    Route::post('/avatar', [app\controller\UserController::class, 'avatar']);
    Route::post('/password', [app\controller\UserController::class, 'password']);
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
