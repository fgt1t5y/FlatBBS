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

namespace support;

use app\model\Guest;
use app\model\User;

/**
 * Class Request
 * @package support
 */
class Request extends \Webman\Http\Request
{
    public function getUser(): User|null
    {
        $user_id = $this->session->get('id');

        if (!$user_id)
            // not a user, seen as a guest
            return new Guest;

        return User::find($user_id);
    }
}
