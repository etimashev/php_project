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

        $dbc = Connection::getConnection();

        pg_prepare($dbc, 'get_user', 'SELECT * FROM users WHERE id = $1');
        $result = pg_execute($dbc, 'get_user', [$request['id']]);

        if (isset(pg_fetch_all($result)[0])) {
            return json_encode(pg_fetch_all($result)[0]);
        } else {
            return [];
        }
    }
}
