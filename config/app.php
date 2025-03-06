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

use support\Request;

putenv('APP_PATH=' . base_path());

return [
    'debug' => getenv('APP_DEBUG') === 'true',
    'error_reporting' => E_ALL,
    'default_timezone' => 'UTC',
    'request_class' => Request::class,
    'public_path' => getenv('APP_PUBLIC_PATH'),
    'runtime_path' => base_path(false) . DIRECTORY_SEPARATOR . 'runtime',
    'controller_suffix' => 'Controller',
    'controller_reuse' => false,
];
