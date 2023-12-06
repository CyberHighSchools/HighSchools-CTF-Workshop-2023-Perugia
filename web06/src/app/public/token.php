<?php
$token = $_SERVER['HTTP_X_API_TOKEN'] ?? null;
if ($token === null) {
    die('Missing X-API-Token');
}
echo "Hello user, your token is: $token";
