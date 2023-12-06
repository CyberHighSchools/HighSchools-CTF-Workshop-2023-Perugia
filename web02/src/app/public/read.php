<?php

// Check that the file name is specified
if (!isset($_GET['file'])) {
    die('No file specified');
}
// Build the file path
$file = '../storage/soluzioni/' . $_GET['file'];

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
