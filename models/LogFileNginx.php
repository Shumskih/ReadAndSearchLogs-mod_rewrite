<?php
require_once ROOT . '/models/LogFile.php';
require_once ROOT . '/models/SearchNginx.php';

class LogFileNginx implements LogFile
{
    private $listOfCheckedLogs = [];

    private $logFileNames = [];

    public function searchLogs($searchString = NULL)
    {
        $listOfLogs = NULL;

        if (count($this->listOfCheckedLogs) > 0) {
            $listOfLogs = $this->getListOfCheckedLogs($this->listOfCheckedLogs);
        } else {
            $listOfLogs = $this->getListOfAllLogs();
        }

        if ($searchString == NULL) {
            SearchNginx::searchAll($listOfLogs);
        }
        if ($searchString != NULL) {
            if (!strpos($searchString, '&&') && !strpos($searchString, '||') && $searchString) {
                SearchNginx::searchSingle($searchString, $listOfLogs);
            }
            if (strpos($searchString, '&&', 0) && !strpos($searchString, '||', 0)) {
                SearchNginx::searchDouble($searchString, $listOfLogs);
            }
            if (strpos($searchString, '||')) {
                $searchString = explode('||', $searchString);
                if (strpos($searchString[0], '&&', 0)) {
                    SearchNginx::searchDouble($searchString[0], $listOfLogs);
                } else {
                    SearchNginx::searchSingle($searchString[0], $listOfLogs);
                }
                if (count($_SESSION) == 0 && strpos($searchString[1], '&&', 0)) {
                    SearchNginx::searchDouble($searchString[1], $listOfLogs);
                } else if (count($_SESSION) == 0 && !strpos($searchString[1], '&&', 0)) {
                    SearchNginx::searchSingle($searchString[1], $listOfLogs);
                }
            }
        }
    }

    public function getListOfAllLogs()
    {
        $listOfAllLogs = [];

        if (is_dir(PATH_TO_NGINX_LOGS_FOLDER)) {
            $files = glob(PATH_TO_NGINX_LOGS_FOLDER . DIRECTORY_SEPARATOR . '*.log');
            foreach ($files as $file) {
                array_push($listOfAllLogs, $file);
            }
            return $listOfAllLogs;
        }
        return $notADir = 'Not a directory!';
    }

    public function getLogFileNames()
    {
        $listOfLogs = $this->getListOfAllLogs();

        foreach ($listOfLogs as $log) {
            $log = explode(DIRECTORY_SEPARATOR, $log);
            array_push($this->logFileNames, end($log));
        }

        return $this->logFileNames;
    }

    public function setListOfCheckedLogs($listOfCheckedLogs)
    {
        $this->listOfCheckedLogs = array_merge($this->listOfCheckedLogs, $listOfCheckedLogs);
    }

    public function getListOfCheckedLogs($checkedLogs = NULL)
    {
        $listOfLogs = [];

        if (is_dir(PATH_TO_NGINX_LOGS_FOLDER)) {
            $files = glob(PATH_TO_NGINX_LOGS_FOLDER . DIRECTORY_SEPARATOR . '*.log');
            foreach ($files as $file) {
                if ($checkedLogs != NULL) {
                    $fileName = explode(DIRECTORY_SEPARATOR, $file);

                    foreach ($checkedLogs as $log) {
                        if ($log == end($fileName)) {
                            array_push($listOfLogs, $file);
                        }
                    }
                }
            }
            return $listOfLogs;
        }
        return $notADir = 'Not a directory!';
    }
}