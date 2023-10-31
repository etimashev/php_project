<?php

namespace Utility;

use Throwable;

class Handler
{
    public static function init()
    {
        set_error_handler(function (int $errNo, string $errStr, string $errFile, int $errLine) {
            if (!(error_reporting() & $errNo)) {
                return false;
            }

            $errStr = htmlspecialchars($errStr);
            $message = '';

            switch ($errNo) {
                case E_USER_ERROR:
                    $message = "Фатальная ошибка [$errNo] $errStr. Строка $errLine файла $errFile";
                    Logger::error($message);

                    http_response_code(500);
                    break;
                case E_USER_WARNING:
                    $message = "Пользовательское предупреждение [$errNo] $errStr. Строка $errLine файла $errFile";
                    Logger::warning($message);
                    break;
                case E_USER_NOTICE:
                    $message = "Пользовательское уведомление [$errNo] $errStr. Строка $errLine файла $errFile";
                    Logger::warning($message);
                    break;
                default:
                    $message = "Неизвестная ошибка: [$errNo] $errStr. Строка $errLine файла $errFile";
                    Logger::error($message);

                    http_response_code(500);
                    break;
            }

            die(json_encode(['error' => $message]));

            return true;
        });

        set_exception_handler(function (Throwable $e) {
            $message = 'Не перехваченное исключение: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString();

            Logger::error($message);

            echo json_encode(['error' => $message]);
        });
    }
}
