<?php
include_once 'init.php';

function redirect($url, $msg = null) {
    if ($msg) {
        set_message($msg);
    }
    header('Location: ' . $url);
    die();
}

// if is a POST try to login
if ($_SERVER['REQUEST_METHOD'] == 'POST'):
    // Check that the username and password are specified
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        redirect('/', 'Username and password are required');
    }

    // Get the username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check that the username exists
    $hashed_password = hash('sha256', $password);
    $query = "SELECT * FROM users WHERE password = '$hashed_password' AND name = '$username'";
    try {
        $result = $mysql->query($query);
    } catch (Exception $e) {
        redirect('/', 'Query error: ' . $e->getMessage() . '. The query executed is:' . PHP_EOL . $query);
    }
    if (!$result) {
        redirect('/', 'Query error: ' . $mysql->error);
    }

    // If the user exists, set the session and redirect to the home page
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        set_user($user);
        redirect('/');
    } else {
        redirect('/', 'Wrong username or password');
    }
else:
?>
<!doctype html>
<html>
    <head>
        <title>Verifiche</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <script src="/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Verifiche</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav me-auto">
                    </div>
                    <div class="navbar-nav ms-auto">
                        <form class="d-flex" action="/" method="post">
<?php if (is_logged_in()): ?>
                            <span class="text-white"><?= get_user()['name'] ?></span>
<?php else: ?>
                            <input class="form-control me-2" type="text" placeholder="Username" aria-label="Username" name="username">
                            <input class="form-control me-2" type="password" placeholder="Password" aria-label="Password" name="password">
                            <button class="btn btn-success" type="submit">Login</button>
<?php endif; ?>
                        </form>
                </div>
            </div>
        </nav>
<?php if (has_message()): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <span style="white-space: pre"><?= get_message() ?></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove()"></button>
        </div>
<?php endif; ?>
        <main class="container mt-4">
            <h1>Soluzioni verifiche precedenti</h1>
            <p>In questa pagina vengono caricate le soluzioni di tutte le verifiche passate.</p>
            <ul>
<?php
// If the user is not admin show only the published solutions
if (!is_admin()) {
    $where = 'WHERE published = 1';
} else {
    $where = '';
}

// Get the solutions from the database
$query = "SELECT * FROM solutions $where";
$result = $mysql->query($query);
if (!$result) {
    die('Query error: ' . $mysql->error);
}

// Print the solutions
while ($row = $result->fetch_assoc()) {
    if (!$row['published']) {
        $class = 'text-danger';
        $text = ' - da caricare';
    } else {
        $class = '';
        $text = '';
    }
    echo '<li><a href="/read.php?file=' . $row['path'] . '" class="'. $class . '">' . $row['name'] . $text . '</a></li>';
}
?>
            </ul>
        </main>
    </body>
</html>

<?php
endif;
?>
