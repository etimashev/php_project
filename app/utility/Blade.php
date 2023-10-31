<?php

namespace Utility;

use eftec\bladeone\BladeOne;

class Blade
{
    protected static ?BladeOne $blade = null;

    public static function get(): BladeOne
    {
        if (static::$blade) {
            return static::$blade;
        }

        return static::$blade = new BladeOne(__DIR__ . '/../views', __DIR__ . '/../compiles');
    }
}
