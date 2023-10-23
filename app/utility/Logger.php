<?php

namespace Utility;

class Logger
{
    protected static $logDir = __DIR__ . '/../logs';
    protected static $fileName = 'log_';
    protected static $fileExt = '.log';
    protected static $fileStream = null;

    public static function debug($message)
    {
        return static::write($message, 'debug');
    }

    public static function info($message)
    {
        return static::write($message, 'info');
    }

    public static function warning($message)
    {
        return static::write($message, 'warning');
    }

    public static function error($message)
    {
        return static::write($message, 'error');
    }

    public static function init(): void
    {
        if (static::$fileStream) {
            return;
        }

        if (!file_exists(static::$logDir)) {
            return;
        }

        $filePath = implode(DIRECTORY_SEPARATOR, [
            static::$logDir,
            static::$fileName . date('Y-m-d') . static::$fileExt,
        ]);

        static::$fileStream = fopen($filePath, 'a');
    }

    protected static function write(string $message, string $level = 'debug'): void
    {
        $logEntry = array_map(function ($v) {
            return print_r($v, true);
        }, [
            'timestamp' => time(),
            'message' => $message,
            'level' => $level,
        ]);

        $logLine = date('c', $logEntry['timestamp'])
            . ' [' . $logEntry['level'] . ']: '
            . $logEntry['message'] . PHP_EOL;

        fwrite(static::$fileStream, $logLine);
    }
}
