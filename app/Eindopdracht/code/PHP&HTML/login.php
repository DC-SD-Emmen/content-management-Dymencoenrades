<?php

if (!isset($_SESSION)) {
    session_start();
}

spl_autoload_register(function ($class) {
    include '../../classes/' . $class . '.php';
  });

  $new_database = new Database();
  $new_usermanager = new UserManager($new_database);
  $new_gamemanager = new GameManager($new_database);
  $new_connection = $new_database->create_connection();

    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', '/path/to/error.log');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/Login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="text-center mt-3">
        <a href="register.php" class="btn btn-secondary">Register</a>
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $new_usermanager->login($username, $password);
    // $user_id = 1;
    // $game_id = 1;
    // $new_gamemanager->favoriteGame($user_id, $game_id);
}
?>