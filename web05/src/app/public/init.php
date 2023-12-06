<?php
// On direct access die
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    die('No direct access allowed');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'db.php';

session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = uniqid();
}

session_write_close();

$MESSAGE = [];

function set_message($type, $message) {
    global $MESSAGE;
    $datetime = date('Y-m-d H:i:s');
    $MESSAGE[$type] = '[' . $datetime . '] ' . htmlspecialchars($message);
}

function has_message($type) {
    global $MESSAGE;
    return isset($MESSAGE[$type]);
}

function get_message($type) {
    global $MESSAGE;
    if (!has_message($type)) {
        return null;
    }
    $message = $MESSAGE[$type];
    unset($MESSAGE[$type]);
    return $message;
}
