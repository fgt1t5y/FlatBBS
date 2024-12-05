<?php

namespace support;

use Webman\http\Request;

class Guard
{
    public function check(Request $request): bool{
        return false;
    }
}
