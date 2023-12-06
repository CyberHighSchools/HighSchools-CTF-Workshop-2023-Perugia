<?php

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
