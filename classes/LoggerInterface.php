<?php

namespace Log;

/**
 * Отвечает за запись логов об изменении пользователей и ошибок
 * Interface LoggerInterface
 * @package Log
 */
interface LoggerInterface
{
    public function log($message);
}
