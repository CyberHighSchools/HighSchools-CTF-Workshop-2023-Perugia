<?php
if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
    die('Only localhost is allowed');
}
echo getenv('FLAG');
