<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['expression'])) {
    $result = eval('return ' . $_POST['expression'] . ';');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Calculator</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <script src="/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <main class="container mt-4">
            <h1 class="mb-4">Calcolatrice</h1>
            <form method="post">
                <textarea class="form-control" name="expression" rows="10"><?php echo $_POST['expression'] ?? '5+2*pow(3,6)-126'; ?></textarea>
                <input type="submit" class="btn btn-primary mt-4" value="Calcola">
            </form>
            <?php if (isset($result)): ?>
                <p class="mt-2">Result: <?php echo $result; ?></p>
            <?php endif; ?>
        </main>
    </body>
</html>
