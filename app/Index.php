<?php
ob_start();
$sigma = false;
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username']) || $_SESSION['username'] == null) {
    $sigma = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Username and Password</title>
</head>
<body>
    <?php
    $username = "your_username";
    $password = "your_password";
    ?>
    <h1>Username and Password</h1>
    <form method="POST">
        <button>logout</button>
    </form>
    <?php
    if ($sigma == false) {
        echo "<p>Username: " . $_SESSION['username'] . "</p>";
        echo "<p>Password: " . $_SESSION['password'] . "</p>";
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