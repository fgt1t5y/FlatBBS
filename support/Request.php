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

    public ?User $user = null;

    public function getUser(): User
    {
        $user_id = session()->get('id');

        if ($user_id) {
            $this->user = User::find($user_id);
        } else {
            // not a user, seen as a guest
            $this->user = new Guest;
        }

        return $this->user;
    }

    public function assertLogin()
    {
        if (!session()->has('id')) {
            throw new APIException('$exception.unauthorized', STATUS_UNAUTHORIZED);
        }
    }

    public function assertPermission(string $permission)
    {
        if ($this->user === null) {
            $this->getUser();
        }

        if ($this->user->isGuest()) {
            throw new APIException('$exception.unauthorized', STATUS_UNAUTHORIZED);
        }

        if (!$this->user->hasPermission($permission)) {
            throw new APIException('$exception.forbidden', STATUS_FORBIDDEN);
        }
    }
}
