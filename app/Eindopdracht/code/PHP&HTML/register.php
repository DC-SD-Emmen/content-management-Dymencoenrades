<?php

if (!isset($_SESSION)) {
    session_start();
}

spl_autoload_register(function ($class) {
    include '../../classes/' . $class . '.php';
  });

//   $new_database = new Database();
//   $new_connection = $new_database->create_connection();

  $new_database = new Database();
  $new_usermanager = new UserManager($new_database);
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
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <div class="text-center mt-3">
        <a href="login.php" class="btn btn-secondary">Login</a>
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "User added";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $new_usermanager->AddUser($username, $password, $email);
}
?>