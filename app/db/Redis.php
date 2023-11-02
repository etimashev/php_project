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
            $user = getenv('REDIS_READ_USER') ? getenv('REDIS_READ_USER') : 'reader';
            $pass = getenv('REDIS_READ_PASSWORD') ? getenv('REDIS_READ_PASSWORD') : 'readerpass';

            static::$connection = new GlobalRedis([
                'host' => $host,
                'port' => (int) $port,
                'auth' => [$user, $pass],
            ]);
        } catch (Throwable $e) {
            error_log($e->getMessage());

            throw $e;
        }

        return static::$connection;
    }

    public static function getSeeder(): GlobalRedis
    {
        try {
            $host = getenv('REDIS_HOST') ? getenv('REDIS_HOST') : 'localhost';
            $port = getenv('REDIS_PORT') ? getenv('REDIS_PORT') : 6379;
            $user = getenv('REDIS_SEED_USER') ? getenv('REDIS_SEED_USER') : 'seeder';
            $pass = getenv('REDIS_SEED_PASSWORD') ? getenv('REDIS_SEED_PASSWORD') : 'seederpass';

            return new GlobalRedis([
                'host' => $host,
                'port' => (int) $port,
                'auth' => [$user, $pass],
            ]);
        } catch (Throwable $e) {
            error_log($e->getMessage());

            throw $e;
        }
    }
}
