<?php


function vardump($input)
{
    if (!$input) {
        return false;
    }
    if (gettype($input) == "boolean") {
        echo var_dump($input);
    } else {
        echo "<pre>" . print_r($input, true) . "</pre>";
    }
}