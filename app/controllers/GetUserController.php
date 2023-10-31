<?php

namespace Controllers;

use DB\Redis;
use Utility\Blade;

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

        $result = json_decode($redis->get($accountId), true);

        $blade = Blade::get();

        if ($result) {
            echo $blade->run('landing', $result);
            return;
        } else {
            http_response_code(404);
            return json_encode(['data' => [], 'message' => "Пользователь с AccountId '$accountId' не найден"]);
        }
    }
}
