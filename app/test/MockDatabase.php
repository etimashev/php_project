<?php

namespace Test;

require_once __DIR__ . '/../db/Connection.php';
use DB\Connection;
require_once __DIR__ . '/../utility/EnvLoader.php';
use Utility\EnvLoader;

class MockDatabase
{
    protected static $data = [
        ['62f87e88ef72a5216b630111', 1, 1, 10, 1, 1, '{"Саратов"}'],
        ['6499b12237029e6e1dde11ea', 1, 1, 22, 5, 1, '{"Анапа"}'],
        ['644d9817cd1c14b31232cb9f', 2, 2, 17, 150, 2, '{"Москва", "Люберцы"}'],
        ['64b00757707eb0484bc19648', 2, 5, 31, 3, 2, '{"Санкт-Петербург", "Москва"}'],
        ['6487c5434a376c4610342b3c', 3, 6, 75, 10, 2, '{"Волгоград", "Казань"}'],
        ['611abcc8235ea7908279c597', 3, 8, 145, 33, 1, '{"Геленджик"}'],
        ['5cb5cd0f5d3edd00016dd0ba', 3, 10, 622, 31, 1, '{"Москва"}'],
        ['644f8e1f257f76e21a949069', 4, 12, 453, 61, 1, '{"Адлер"}'],
        ['60fd3f050220e247dfa8722d', 4, 29, 360, 62, 1, '{"Москва"}'],
        ['625e59b4711e52dbdf9b4367', 5, 34, 256, 51, 2, '{"Москва", "Митино"}'],
        ['645368b8dd3cb7bd06935b98', 5, 52, 514, 86, 3, '{"Москва", "Зеленоградск", "Светлогорск"}'],
        ['61ba1d82d55bcaa7b53a1690', 5, 90, 934, 151, 1, '{"Москва"}'],
        ['60b0fd3cdf365620d27e5ed3', 6, 118, 502, 120, 1, '{"Москва"}'],
        ['6280f9d91937cf93d7d53736', 6, 147, 1454, 181, 2, '{"Люберцы", "Москва"}'],
        ['60d352e1fd6fc63794de501b', 6, 237, 2618, 484, 2, '{"Красногорск", "Москва"}'],
    ];

    public static function init()
    {
        EnvLoader::init();

        static::createTable();
        static::fillTable();
    }

    protected static function createTable()
    {
        $dbc = Connection::getConnection();
        $table = getenv('POSTGRES_TABLE') ? getenv('POSTGRES_TABLE') : 'users';

        pg_prepare($dbc, 'create_table', 'CREATE TABLE ' . $table . '(
            "AccountId" varchar,
            "UserSegment" integer,
            "Rides" integer,
            "Duration" integer,
            "Distance" integer,
            "LocationCnt" integer,
            "LocationName" varchar[]
        );');

        pg_execute($dbc, 'create_table', []);

        echo pg_last_error($dbc);
    }

    protected static function fillTable()
    {
        $dbc = Connection::getConnection();
        $table = getenv('POSTGRES_TABLE') ? getenv('POSTGRES_TABLE') : 'users';

        pg_prepare($dbc, 'fill_table', 'INSERT INTO ' . $table . '(
            "AccountId",
            "UserSegment",
            "Rides",
            "Duration",
            "Distance",
            "LocationCnt",
            "LocationName"
        ) values ($1, $2, $3, $4, $5, $6, $7);');

        foreach (self::$data as $row) {
            pg_execute($dbc, 'fill_table', $row);
        }

        echo pg_last_error($dbc);
    }
}
