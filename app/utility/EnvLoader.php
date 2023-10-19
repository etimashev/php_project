<?php

namespace Utility;

use ErrorException;

class EnvLoader
{
    protected static string $envFilePath = '';

    public static function init()
    {
        self::$envFilePath = realpath(__DIR__ . '/../.env');

        if (!is_file(self::$envFilePath)) {
            throw new ErrorException("Environment File is Missing.");
        }

        if (!is_readable(self::$envFilePath)) {
            throw new ErrorException("Permission Denied for reading the " . (self::$envFilePath) . ".");
        }

        self::writeVariables();
    }

    protected static function writeVariables(): void
    {
        $envVars = array();

        if ($fopen = fopen(self::$envFilePath, 'r')) {
            while (($line = fgets($fopen)) !== false) {
                $lineIsComment = (substr(trim($line), 0, 1) == '#') ? true : false;

                if ($lineIsComment || empty(trim($line))) {
                    continue;
                }

                $lineNoComment = explode("#", $line, 2)[0];

                $envExp = preg_split('/(\s?)\=(\s?)/', $lineNoComment);
                $envName = trim($envExp[0]);
                $envValue = isset($envExp[1]) ? trim($envExp[1]) : "";
                $envVars[$envName] = $envValue;
            }

            fclose($fopen);
        }

        foreach ($envVars as $name => $value) {
            putenv("{$name}={$value}");
        }
    }
}
