<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

$dsn = 'mysql:dbname=toto;host=localhost;port=3306;charset=utf8';

$user = 'toto';
$pwd = 'toto';

$pdo = new PDO($dsn, $user, $pwd, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);