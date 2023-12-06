<?php
include_once 'init.php';
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'buy') {
        buy_coin();
    } else if ($_GET['action'] == 'sell') {
        sell_coin();
    } else if ($_GET['action'] == 'buy_flag') {
        $user = get_user();
        if ($user['balance'] < 110) {
            set_message('warning', 'Non hai abbastanza soldi');
        } else {
            set_message('success', getenv('FLAG'));
        }
    }
}
$user = get_user();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Trading</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <script src="/js/bootstrap.bundle.min.js"></script>
        <script>
            // When a button is clicked disable it to prevent double submission
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('button').forEach(button => {
                    button.addEventListener('click', () => {
                        button.disabled = true;
                        button.classList.add('disabled');
                        button.closest('form').submit();
                    });
                });
            });
        </script>
    </head>
    <body>
        <main class="container mt-4">
            <h1 class="mb-4">Trading</h1>
            <?php foreach (['success', 'warning'] as $type): ?>
                <?php if (has_message($type)): ?>
                <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
                    <span style="white-space: pre"><?= get_message($type) ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove()"></button>
                </div>
                <?php endif ?>
            <?php endforeach ?>
            <p class="lead">Benvenuto, utente <?= $user['username'] ?></p>
            <div class="row">
                <div class="col-6">
                    <h2>Saldo: <?= $user['balance'] ?>€</h2>
                </div>
                <div class="col-6">
                    <h2>PGCoin: <?= $user['coins'] ?></h2>
                </div>
            </div>
            <hr>
            <p>1 PGCoin = 10€</p>
            <div class="row mt-4">
                <div class="col-6">
                    <form action="/" method="get" class="mb-3">
                        <input type="hidden" name="action" value="buy">
                        <button type="submit" class="btn btn-primary">Compra</button>
                    </form>
                </div>
                <div class="col-6">
                    <form action="/" method="get" class="mb-3">
                        <input type="hidden" name="action" value="sell">
                        <button type="submit" class="btn btn-secondary">Vendi</button>
                    </form>
                </div>
            </div>
            <p>1 FLAG = 110€</p>
            <div class="row mt-4">
                <div class="col-6">
                    <form action="/" method="get" class="mb-3">
                        <input type="hidden" name="action" value="buy_flag">
                        <button type="submit" class="btn btn-primary">Compra</button>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>
