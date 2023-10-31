<?php

namespace Test;

require_once __DIR__ . '/../db/Connection.php';
require_once __DIR__ . '/../db/Postgres.php';
use DB\Postgres;
require_once __DIR__ . '/../db/Redis.php';
use DB\Redis;
require_once __DIR__ . '/../utility/EnvLoader.php';
use Utility\EnvLoader;

class DatabaseToRedis
{
    public static function init()
    {
        EnvLoader::init();

        static::loadData();
    }

    protected static function loadData()
    {
        $dbc = Postgres::getConnection();
        $redis = Redis::getConnection();

        $table = getenv('POSTGRES_TABLE') ? getenv('POSTGRES_TABLE') : 'users';
        $idField = getenv('POSTGRES_TABLE_ID') ? getenv('POSTGRES_TABLE_ID') : 'AccountId';

        pg_prepare($dbc, 'get_users', 'SELECT
            "' . $idField . '",
            "usersegment",
            "rides",
            "duration",
            "distance",
            "locationcnt",
            array_to_json(string_to_array(regexp_replace("locationname", \'\[|\]|\'\'\', \'\', \'g\'), \', \')) AS "locationname"
         FROM ' . $table . ' LIMIT $1 OFFSET $2');

        $total = 0;
        $limit = 100000;
        $offset = 0;

        static::print('Fill started');

        do {
            $result = pg_execute($dbc, 'get_users', [$limit, $offset]);
            $fetched = pg_fetch_all($result);

            foreach ($fetched as $row) {
                $row['locationname'] = json_decode($row['locationname'], JSON_UNESCAPED_UNICODE);

                $redis->set($row[$idField], json_encode($row, JSON_UNESCAPED_UNICODE));
            }

            $count = count($fetched);
            $total += $count;

            static::print('Filled ' . "$count/$total" . ' rows');

            $offset += $limit;
        } while ($count === $limit);

        static::print('Fill ended');

        echo pg_last_error($dbc);
    }

    protected static function print(string $message)
    {
        echo '[' . date('h:i:s') . ']: ' . $message . PHP_EOL;
    }
}
