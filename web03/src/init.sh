#!/bin/sh
set -e

echo "$FLAG" >> /usr/local/apache2/htdocs/storage/soluzioni/20240509.txt
php82 /seed.php
