<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

spl_autoload_register(function ($class) {
    include '../../classes/' . $class . '.php';
});

$new_database = new Database();
$new_gamemanager = new GameManager($new_database);
$new_connection = $new_database->create_connection();

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log');

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['unfavorite'])) {
    $game_id = $_POST['game_id'];
    $new_gamemanager->unfavoriteGame($user_id, $game_id);
    header("Location: favorites.php");
    exit();
}

$favorites = $new_gamemanager->getFavoriteGames($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Games</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/Index.css">
    
</head>
<body>
    <div id="main">
        <div class="top-buttons">
            <form method="post" class="logout-form">
                <button type="submit" name="logout" class="btn btn-secondary">Logout</button>
            </form>
            <a href="index.php" class="btn btn-primary switch-button">Games Library</a>
        </div>

        <div id="gameslib">Favorite Games</div>

        <div id="pizza">
            <?php
            foreach ($favorites as $game) {
                ?>
                <div class="game">
                    <div class="game_text"><?php echo $game->get_title(); ?></div>
                    <img id="bg_image" class="bg_image" src="../../items/<?php echo $game->get_gameicon(); ?>" alt="Game Icon">
                    <div id="description_div" class="description_div"><?php echo $game->get_description(); ?></div>
                    <div id="genre_div" class="genre_div"><?php echo $game->get_genre(); ?></div>
                    <div id="platform_div" class="platform_div"><?php echo $game->get_platform(); ?></div>
                    <div id="release_year_div" class="release_year_div"><?php echo $game->get_release_date(); ?></div>
                    <div id="rating_div" class="rating_div"><?php echo $game->get_rating(); ?></div>
                    <form method="post">
                        <input type="hidden" name="game_id" value="<?php echo $game->get_id(); ?>">
                        <button type="submit" name="unfavorite" class="btn btn-danger">Unfavorite</button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <script src="javascript.js" type="text/javascript"></script>
</body>
</html>
