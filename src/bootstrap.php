<?php

require  __DIR__ . '/App.php';
require  __DIR__ . '/Console.php';

$app = new \Frt\App();

function getAllPossible()
{
    global $app;
    return $app->getAllPossible();
}

function attempt($pass)
{
    global $app;
    return $app->attempt($pass);
}