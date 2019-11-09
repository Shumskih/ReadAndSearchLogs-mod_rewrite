<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/config/config.php';
require_once ROOT . '/helpers/vardump.php';
require_once ROOT . '/models/LogFileNginx.php';

session_start();

$title = 'NGINX logs';

$search = new LogFileNginx();

if (isset($_GET['logs'])) {
    $search->setListOfCheckedLogs($_GET['logs']);
}
if (isset($_GET['searchString'])) {
    $_GET['searchString'] = trim($_GET['searchString']);

    if ($_GET['searchString'] != NULL) {
        $search->searchLogs($_GET['searchString']);
    }
}
if (!isset($_GET['searchString']) || isset($_GET['searchString']) && $_GET['searchString'] == NULL) {
    $search->searchLogs();
}
$listOfAllLogs = $search->getLogFileNames();

include $_SERVER['DOCUMENT_ROOT'] . '/views/nginx.html.php';

session_unset();
