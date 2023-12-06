<?php

include_once 'init.php';

// Check that the file name is specified
if (!isset($_GET['file'])) {
    die('No file specified');
}
// Build the file path
$file = $_GET['file'];

// Check that the file is in the database
$query = sprintf("SELECT * FROM solutions WHERE path = '%s' LIMIT 1", $mysql->real_escape_string($file));
$result = $mysql->query($query);
if (!$result) {
    die('Query error: ' . $mysql->error);
}
if ($result->num_rows == 0) {
    die('File not in db');
}

// Check that the user has access to the file
$file_db = $result->fetch_assoc();
if (!$file_db['published'] && !is_admin()) {
    die('Access denied, this file is not published and you are not an admin');
}

$file = STORAGE_PATH . $file;

// Check that the file exists
if (!file_exists($file)) {
    die('File not found');
}

header('Content-Type: text/plain');

// If is a directory, show the list of files
if (is_dir($file)) {
    $files = scandir($file);
    foreach ($files as $f) {
        echo $f . "\n";
    }
    die();
}

// Return the file
readfile($file);
