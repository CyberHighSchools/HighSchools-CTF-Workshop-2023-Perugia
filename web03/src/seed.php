<?php

$base_path = '/usr/local/apache2/htdocs/';
include_once $base_path . '/public/db.php';

// Clear the database
$query = 'TRUNCATE TABLE users';
if (!$mysql->query($query)) {
    fwrite(STDERR, 'Query error: ' . $mysql->error);
    exit(1);
}
$query = 'TRUNCATE TABLE solutions';
if (!$mysql->query($query)) {
    fwrite(STDERR, 'Query error: ' . $mysql->error);
    exit(1);
}

// Create admin user inserting a new row in the users table
// The password is hashed using sha2 because we want to use the same hash function used in the login page
// The password is random
$username = 'admin';
$random_password = bin2hex(random_bytes(16));
$password = hash('sha256', $random_password);
$query = "INSERT INTO users (`name`, `password`, `is_admin`) VALUES ('$username', '$password', 1)";
if (!$mysql->query($query)) {
    fwrite(STDERR, 'Query error: ' . $mysql->error);
    exit(1);
}

// Print the password
echo "Admin password: $random_password\n";

// Add the solutions to the database
// The solutions are stored in the solutions directory
$files = scandir($base_path . '/storage/soluzioni');
$published = 1;
foreach ($files as $f) {
    if ($f == '.' || $f == '..') {
        continue;
    }
    $path = '/soluzioni/' . $f;
    $content = file_get_contents($base_path . '/storage' . $path);
    if (strpos($content, 'flag') !== false) {
        $published = 0;
    }
    $name = strtok($content, "\n");
    $name = trim($name);

    $query = "INSERT INTO solutions (`name`, `path`, `published`) VALUES ('$name', '$path', $published)";
    if (!$mysql->query($query)) {
        fwrite(STDERR, 'Query error: ' . $mysql->error);
        exit(1);
    }    
}
