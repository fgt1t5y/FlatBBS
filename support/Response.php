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

/**
 * Class Response
 * @package support
 */
class Response extends \Webman\Http\Response
{
    protected $is_success = true;
    protected $data = [];
    protected int $code = 200;

    public function success()
    {
        $this->is_success = true;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function failed(int $code)
    {
        $this->code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function isSuccess()
    {
        return $this->is_success;
    }

    public function toJson()
    {
        return json_encode(['code' => $this->code, 'data' => $this->data]);
    }
}
