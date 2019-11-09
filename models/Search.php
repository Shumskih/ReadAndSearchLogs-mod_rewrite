<?php


abstract class Search
{
    public static abstract function searchSingle($searchString, $listOfLogs);

    public static abstract function searchDouble($searchString, $listOfLogs);

    public static abstract function searchAll($listOfLogs);

    public static function notFound()
    {
        return 'Nothing Found!';
    }
}