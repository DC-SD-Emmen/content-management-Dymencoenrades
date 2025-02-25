<?php
ob_start();
$sigma = false;
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username']) || $_SESSION['username'] == null) {
    $sigma = true;
}


spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
  });

  $new_database = new Database();
  $new_gamemanager = new GameManager($new_database);
  $new_connection = $new_database->create_connection();

    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', '/path/to/error.log');

?>



<!DOCTYPE html>
<html>
<head>
    <title>Display Username and Password</title>
</head>
<body>
    <h1>Username and Password</h1>
    <form method="POST">
        <button>logout</button>
    </form>
    <?php
    if ($sigma == false) {
        echo "<p>Username: " . $_SESSION['username'] . "</p>";
        echo "<p>Password: " . $_SESSION['password'] . "</p>";
        $userid = $new_gamemanager->TEST($_SESSION['username']);
        $games = $new_gamemanager->TEST2($userid);
        if ($games) {
            foreach ($games as $game) {
                echo "<div><h3>" . $game['title'] . "</h3></div>";
            }
        }
        
    } else {
        header("Location: /login.php");
        ob_end_flush();
        die();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_destroy();
        header("Location: /login.php");
        ob_end_flush();
        die();
    }

    ?>
</body>
</html>