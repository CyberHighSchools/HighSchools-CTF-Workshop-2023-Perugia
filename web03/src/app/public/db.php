<?php
// On direct access die
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    die('No direct access allowed');
}

define('DB_HOST', getenv('MYSQL_HOST'));
define('DB_NAME', getenv('MYSQL_DATABASE'));
define('DB_USER', getenv('MYSQL_USER'));
define('DB_PASSWORD', getenv('MYSQL_PASSWORD'));

$mysql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysql->connect_error) {
    die('Connection error: ' . $mysql->connect_error);
}
$mysql->set_charset('utf8mb4');
