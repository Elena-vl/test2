<?php


namespace Log;

/**
 * Запись логов в файл
 * Class Errors
 * @package Log
 */
class Errors implements LoggerInterface
{
    public $filePath;

    public function __construct() {
        $documentRoot = str_replace('\\', '/', realpath(dirname(__FILE__) . '/../'));
        $folder = $documentRoot . '/logs';
        if (!file_exists($folder) || !is_dir($folder)) {
            if (!mkdir($folder, 0777, true)) {
                file_put_contents($documentRoot . '/all_log.log', 'Не удалось создать директорию ' . $folder . PHP_EOL, FILE_APPEND);
                exit();
            }
        }
        $this->filePath = $folder . '/log_' . time() . '.log';
    }

    public function log($message)
    {
        file_put_contents($this->filePath, $message . PHP_EOL, FILE_APPEND);
    }
}
