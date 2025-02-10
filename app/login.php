<?php

$host = "mysql"; // Le host est le nom du service, présent dans le docker-compose.yml
$dbname = "my-wonderful-website";
$charset = "utf8";
$port = "3306";


spl_autoload_register(function ($class) {
    include '../../classes/' . $class . '.php';
  });
  
  $new_database = new Database();
  $new_gamemanager = new GameManager($new_database);
  $new_connection = $new_database->create_connection();

    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', '/path/to/error.log');

?>

<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Login">
    </form>
    <a href="register.php">Register</a>
</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

}

?>