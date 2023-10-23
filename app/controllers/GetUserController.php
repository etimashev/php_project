<?php

namespace Controllers;

use DB\Connection;

class GetUserController
{
    public function __invoke($request)
    {
        if (!isset($request['id'])) {
            http_response_code(422);
            return;
        }

        $accountId = $request['id'];
        $dbc = Connection::getConnection();
        $table = getenv('POSTGRES_TABLE') ? getenv('POSTGRES_TABLE') : 'users';

        pg_prepare($dbc, 'get_user', 'SELECT
            "AccountId",
            "UserSegment",
            "Rides",
            "Duration",
            "Distance",
            "LocationCnt",
            array_to_json("LocationName") as "LocationName"
         FROM ' . $table . ' WHERE "AccountId" = $1');

        $result = pg_execute($dbc, 'get_user', [$accountId]);

        if (isset(pg_fetch_all($result)[0])) {
            return json_encode(['data' => pg_fetch_all($result)[0]]);
        } else {
            http_response_code(404);
            return json_encode(['data' => [], 'message' => "Пользователь с AccountId '$accountId' не найден"]);
        }
    }
}
