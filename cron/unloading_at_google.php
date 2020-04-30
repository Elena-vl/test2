#!/usr/bin/php
<?php
$documentRoot = str_replace('\\', '/', realpath(dirname(__FILE__) . '/../'));

include_once $documentRoot . '/classes/LoggerInterface.php';
include_once $documentRoot . '/classes/Errors.php';
include_once $documentRoot . '/classes/Logger.php';
include_once $documentRoot . '/classes/GoogleClient.php';

use Google\GoogleClient;
use Log\Errors;
use Log\Logger;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
set_time_limit(0);

$date = date("Y-m-d 00:00:00", strtotime("yesterday"));
$dataChanges = (new Logger())->listLog($date);

if ($dataChanges) {
    (new GoogleClient(new Errors()))->insertDate($dataChanges);
    file_put_contents($documentRoot . '/google_log.log', $date . ' . Выгружено записей: ' . count($dataChanges) . PHP_EOL, FILE_APPEND);
} else {
    file_put_contents($documentRoot . '/google_log.log', $date . ' . Изменений не было.' . PHP_EOL, FILE_APPEND);
}
