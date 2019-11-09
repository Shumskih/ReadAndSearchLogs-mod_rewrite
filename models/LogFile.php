<?php


interface LogFile
{
    function searchLogs($searchString = NULL);

    function getListOfAllLogs();

    function setListOfCheckedLogs($listOfCheckedLogs);

    function getListOfCheckedLogs($checkedLogs = NULL);

    function getLogFileNames();
}