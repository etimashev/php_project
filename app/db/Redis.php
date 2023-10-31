<?php

namespace DB;

use Redis as GlobalRedis;
use Throwable;

/** @method static \Redis getConnection()  */
class Redis extends Connection
{
    protected static ?GlobalRedis $connection = null;

    protected static function connect(): GlobalRedis
    {
        try {
            $host = getenv('REDIS_HOST') ? getenv('REDIS_HOST') : 'localhost';
            $port = getenv('REDIS_PORT') ? getenv('REDIS_PORT') : 6379;

            static::$connection = new GlobalRedis([
                'host' => $host,
                'port' => (int) $port,
            ]);
        } catch (Throwable $e) {
            error_log($e->getMessage());

            throw $e;
        }

        return static::$connection;
    }
}
