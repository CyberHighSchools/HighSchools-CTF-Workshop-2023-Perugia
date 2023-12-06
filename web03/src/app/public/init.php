<?php
// On direct access die
if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])) {
    die('No direct access allowed');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'db.php';

define('STORAGE_PATH', realpath(__DIR__ . '/../storage'));

session_start();

// Check if the user is logged in
function is_logged_in() {
    return isset($_SESSION['user']);
}

// Check if the user is an admin
function is_admin() {
    return is_logged_in() && $_SESSION['user']['is_admin'];
}

function get_user() {
    return $_SESSION['user'];
}

function set_user($user) {
    $_SESSION['user'] = $user;
}

function set_message($message) {
    $_SESSION['message'] = htmlspecialchars($message);
}

function has_message() {
    return isset($_SESSION['message']);
}

// Get the message and delete it
function get_message() {
    if (!has_message()) {
        return null;
    }
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
    return $message;
}
