<?php

namespace app\service;

use app\model\Setting;

class SettingService
{
    public function getArrayValue(string $key): ?array
    {
        $setting = Setting::where('key', $key)->first();

        if (!$setting) {
            return null;
        }

        return json_decode($setting->value, true);
    }
}
