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
        $isArray = getenv('POSTGRES_LOCATION_NAME_ARRAY') === 'true';

        $locationName = $isArray ? 'array_to_json("locationname") as "locationname"' : '"locationname"';

        pg_prepare($dbc, 'get_users', 'SELECT
            "' . $idField . '",
            "usersegment",
            "rides",
            "duration",
            "distance",
            "locationcnt",
            ' . $locationName . '
         FROM ' . $table . ' LIMIT $1 OFFSET $2');

        $limit = 100000;
        $offset = 0;

        do {
            $result = pg_execute($dbc, 'get_users', [$limit, $offset]);
            $fetched = pg_fetch_all($result);

            foreach ($fetched as $row) {
                if ($isArray) {
                    $row['locationname'] = json_decode($row['locationname']);
                }

                $redis->set($row[$idField], json_encode($row, JSON_UNESCAPED_UNICODE));
            }

            $offset += $limit;
        } while (count($fetched) !== 0);

        echo pg_last_error($dbc);
    }
}
