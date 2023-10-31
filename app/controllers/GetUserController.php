<?php

namespace Controllers;

use DB\Postgres;
use DB\Redis;

class GetUserController
{
    public function __invoke($request)
    {
        if (!isset($request['id'])) {
            http_response_code(422);
            return;
        }

        $accountId = $request['id'];
        $redis = Redis::getConnection();

        $result = $redis->get($accountId);

        if ($result) {
            return json_encode(['data' => json_decode($result)]);
        } else {
            http_response_code(404);
            return json_encode(['data' => [], 'message' => "Пользователь с AccountId '$accountId' не найден"]);
        }
    }
}
