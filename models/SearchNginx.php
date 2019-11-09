<?php
require_once ROOT . '/models/Search.php';

class SearchNginx extends Search
{
    public static function searchSingle($searchString, $listOfLogs)
    {
        $searchString = trim($searchString);
        foreach ($listOfLogs as $file) {
            $arr = file($file);
            $fileName = explode(DIRECTORY_SEPARATOR, $file);
            $fileName = $fileName[4];

            foreach ($arr as $k => $v) {
                if (strpos($v, $searchString, 0) !== false) {
                    if (!isset($_SESSION[$fileName])) {
                        $_SESSION[$fileName] = [];
                        array_push($_SESSION[$fileName], $k . '@' . $v);
                    } else {
                        array_push($_SESSION[$fileName], $k . '@' . $v);
                    }
                }
            }
            if (isset($_SESSION[$fileName]) && count($_SESSION[$fileName]) == 0) {
                foreach ($arr as $k => $v) {
                    if (strpos($v, $searchString, 0) !== false) {
                        array_push($_SESSION[$fileName], $k . '@' . $v);
                    }
                }
            }
        }
    }

    public static function searchDouble($searchString, $listOfLogs)
    {
        $searchString = explode('&&', $searchString);
        $searchString[0] = trim($searchString[0]);
        $searchString[1] = trim($searchString[1]);
        foreach ($listOfLogs as $file) {
            $arr = file($file);
            $fileName = explode(DIRECTORY_SEPARATOR, $file);
            $fileName = $fileName[4];

            foreach ($arr as $k => $v) {
                if (preg_match("/(.*($searchString[0]).*($searchString[1]).*)|(.*($searchString[1]).*($searchString[0]).*)/", $v) == 1) {
                    if (!isset($_SESSION[$fileName])) {
                        $_SESSION[$fileName] = [];
                        array_push($_SESSION[$fileName], $k . '@' . $v);
                    } else {
                        array_push($_SESSION[$fileName], $k . '@' . $v);
                    }
                }
            }
        }
    }

    public static function searchAll($listOfLogs)
    {
        foreach ($listOfLogs as $file) {
            $arr = file($file);
            $fileName = explode(DIRECTORY_SEPARATOR, $file);
            $fileName = $fileName[4];

            foreach ($arr as $k => $v) {
                if (!isset($_SESSION[$fileName])) {
                    $_SESSION[$fileName] = [];
                    array_push($_SESSION[$fileName], $k . '@' . $v);
                } else {
                    array_push($_SESSION[$fileName], $k . '@' . $v);
                }
            }
        }
    }
}