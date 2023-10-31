<?php

namespace DB;

abstract class Connection
{
    protected function __construct()
    {
        //
    }

    protected function __clone()
    {
        //
    }

    public static function getConnection()
    {
        if (static::$connection) {
            return static::$connection;
        }

        return static::connect();
    }

    abstract protected static function connect();
}
