<?php

namespace DB;

use Exception;
use PgSql\Connection as PgSqlConnection;

/** @method static \PgSql\Connection getConnection()  */
class Postgres extends Connection
{
    protected static ?PgSqlConnection $connection = null;

    protected static function connect(): PgSqlConnection
    {
        try {
            $host = getenv('POSTGRES_HOST') ? getenv('POSTGRES_HOST') : 'localhost';
            $port = getenv('POSTGRES_PORT') ? getenv('POSTGRES_PORT') : '5432';
            $dbname = getenv('POSTGRES_DB') ? getenv('POSTGRES_DB') : 'postgres';
            $user = getenv('POSTGRES_USER') ? getenv('POSTGRES_USER') : 'postgres';
            $password = getenv('POSTGRES_PASSWORD') ? getenv('POSTGRES_PASSWORD') : 'password';

            $connectionString = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
            static::$connection = pg_connect($connectionString);
        } catch (Exception $e) {
            error_log($e->getMessage());

            throw $e;
        }

        return self::$connection;
    }
}
