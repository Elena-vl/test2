<?php


namespace Google;

$documentRoot = str_replace('\\', '/', realpath(dirname(__FILE__) . '/../'));
require $documentRoot . '/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS='. $documentRoot.'/config/secret.json');

use Exception;
use \Google\Spreadsheet\DefaultServiceRequest;
use \Google\Spreadsheet\ServiceRequestFactory;
use \Google\Spreadsheet\SpreadsheetService;
use Log\LoggerInterface;

/**
 * Запись сводных данных об изменениях пользователей в Google-таблицу
 * Class GoogleClient
 * @package Google
 */
class GoogleClient
{
    protected $worksheet;
    /** @var LoggerInterface */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->init();
    }

    public function init()
    {
        $client = new \Google_Client;

        try {
            $client->useApplicationDefaultCredentials();
            $client->setApplicationName("Something to do with my representatives");
            $client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds']);
            if ($client->isAccessTokenExpired()) {
                $client->refreshTokenWithAssertion();
            }

            $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
            ServiceRequestFactory::setInstance(
                new DefaultServiceRequest($accessToken)
            );

            // Get our spreadsheet
            $spreadsheet = (new SpreadsheetService)
                ->getSpreadsheetFeed()
                ->getByTitle('Log');

            // Get the first worksheet (tab)
            $worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
            $this->worksheet = $worksheets[0];
        } catch(Exception $e){
            $this->logger->log($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
            exit();
        }
    }

    /**
     * Запись данных в Google-таблицу
     * @param $data
     */
    public function insertDate(array $data)
    {
        try {
            $listFeed = $this->worksheet->getListFeed();

            foreach ($data as $row){
                $listFeed->insert([
                    'date' => $row['date'],
                    'type' => "'". $row['type'],
                    'count' => "'". $row['count']
                ]);
            }
        } catch(Exception $e){
            $this->logger->log($e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
        }
    }
}
