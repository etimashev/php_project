<?php

namespace DB;

use Exception;
use PgSql\Connection as PgSqlConnection;

class Connection
{
    protected static ?PgSqlConnection $connection = null;

    protected function __construct()
    {
        //
    }

    protected function __clone()
    {
        //
    }

    public static function getConnection(): PgSqlConnection
    {
        if (self::$connection) {
            return self::$connection;
        }

        return self::connect();
    }

    protected static function connect(): PgSqlConnection
    {
        try {
            $host = getenv('POSTGRES_HOST') ? getenv('POSTGRES_HOST') : 'localhost';
            $port = getenv('POSTGRES_PORT') ? getenv('POSTGRES_PORT') : '5432';
            $dbname = getenv('POSTGRES_DB') ? getenv('POSTGRES_DB') : 'postgres';
            $user = getenv('POSTGRES_USER') ? getenv('POSTGRES_USER') : 'postgres';
            $password = getenv('POSTGRES_PASSWORD') ? getenv('POSTGRES_PASSWORD') : 'password';

            $connectionString = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
            self::$connection = pg_connect($connectionString);
        } catch (Exception $e) {
            error_log($e->getMessage());

            throw $e;
        }

        return self::$connection;
    }
}
