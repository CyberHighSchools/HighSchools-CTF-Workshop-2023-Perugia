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

function query($query, $params = []) {
    global $mysql;
    $stmt = $mysql->prepare($query);
    if (!$stmt) {
        die('Query error: ' . $mysql->error);
    }
    if (count($params) > 0) {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } else if (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        $stmt->bind_param($types, ...$params);
    }
    $result = $stmt->execute();
    if (!$result) {
        die('Query error: ' . $stmt->error);
    }
    return $stmt->get_result();
}

function query_one($query, $params = []) {
    $result = query($query, $params);
    if ($result->num_rows == 0) {
        return null;
    }
    return $result->fetch_assoc();
}

function get_user() {
    $result = query_one('SELECT * FROM users WHERE username = ?', [$_SESSION['username']]);
    if (!$result) {
        query('INSERT INTO users (username, balance, coins) VALUES (?, 100, 0)', [$_SESSION['username']]);
        $result = query_one('SELECT * FROM users WHERE username = ?', [$_SESSION['username']]);
    }
    return $result;
}

// function update_user($user) {
//     query('UPDATE users SET balance = ?, coins = ? WHERE username = ?', [$user['balance'], $user['coins'], $user['username']]);
//     set_message('success', 'Operazione completata');
// }

function buy_coin() {
    $user = get_user();
    if ($user['balance'] < 10) {
        set_message('warning', 'Non hai abbastanza soldi');
        return;
    }
    if ($user['balance'] === 10) sleep(2);  // Simulate a slow operation
    query('UPDATE users SET balance = balance - 10, coins = coins + 1 WHERE username = ?', [$_SESSION['username']]);
    set_message('success', 'Acquistato 1 PGCoin, avevi ' . $user['balance'] . '€');
}

function sell_coin() {
    $user = get_user();
    if ($user['coins'] < 1) {
        set_message('warning', 'Non hai abbastanza PGCoin');
        return;
    }
    if ($user['coins'] === 1) sleep(2);  // Simulate a slow operation
    query('UPDATE users SET balance = balance + 10, coins = coins - 1 WHERE username = ?', [$_SESSION['username']]);
    set_message('success', 'Venduto 1 PGCoin, avevi ' . $user['coins'] . ' PGCoin');
}
