<?php

namespace support;

use support\Guard;
use Attribute;
use Webman\http\Request;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class Gate extends Guard
{
    public string $permission = '';

    public function __construct(string $permission)
    {
        $this->permission = $permission;
    }

    public function check(Request $reuqest): bool
    {
        $session = $reuqest->session();

        if (!$this->permission) {
            return false;
        }

        if (!$session->has('id')) {
            return false;
        }

        if (in_array($this->permission, $session->get('permissions'))) {
            return true;
        } else {
            return false;
        }
    }
}
