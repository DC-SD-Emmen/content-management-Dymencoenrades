<?php

if (!isset($_SESSION)) {
    session_start();
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

?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['favorite'])) {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $game_id = $_POST['game_id'];
            $new_gamemanager->favoriteGame($user_id, $game_id);
            echo "Game favorited";
        } else {
            header("Location: login.php");
            exit();
        }
    } elseif (isset($_POST['unfavorite'])) {
        $game_id = $_POST['game_id'];
        $user_id = $_SESSION['user_id'];
        $new_gamemanager->unfavoriteGame($user_id, $game_id);
        echo "Game unfavorited";
    } elseif (isset($_POST['logout'])) {
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        $new_gamemanager->fileUpload($_FILES["GameIcon"]);
        $new_gamemanager->fileUpload($_FILES["GameBackgroundIcon"]);
        $new_gamemanager->insertGame($_POST, $_FILES["GameIcon"]["name"], $_FILES["GameBackgroundIcon"]["name"]);
        echo "Game inserted";
        // header("Location:refresh");
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/Index.css">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/Index.css">

</head>
<body>
    <div id="main">
        <div class="top-buttons">
            <?php if (isset($_SESSION['user_id'])) { ?>
                <form method="post" class="logout-form">
                    <button type="submit" name="logout" class="btn btn-secondary">Logout</button>
                </form>
                <a href="favorites.php" class="btn btn-primary switch-button">Favorites</a>
            <?php } else { ?>
                <a href="login.php" class="btn btn-primary login-button">Login</a>
            <?php } ?>
        </div>

        <div id="gameslib">Games Library</div>

        <div id="main_frame">
            <img src="../../items/plus.png" id="plusimage" class = "plusimage" >
            <!-- <img src="../../items/minus.png" class="plusimage"> -->
        </div>

        <div id="pizza">

            <!-- <div class="game">
                <div class="game_text">Rainworld</div>
            </div> -->

            <?php

                $games = $new_gamemanager->getAllGames();

                foreach($games as $game) {
                    $isFavorited = isset($_SESSION['user_id']) ? $new_gamemanager->isGameFavorited($_SESSION['user_id'], $game->get_id()) : false;
                    ?>


                    <div class="game">
                        <div class="game_text"><?php echo $game->get_title(); ?></div>
                        <img id = "bg_image" class="bg_image" src="../../items/<?php echo $game->get_gameicon(); ?>" alt="Game Icon">
                        <div id="description_div" class="description_div"><?php echo $game->get_description(); ?></div>
                        <div id="genre_div" class="genre_div"><?php echo $game->get_genre(); ?></div>
                        <div id="platform_div" class="platform_div"><?php echo $game->get_platform(); ?></div>
                        <div id="release_year_div" class="release_year_div"><?php echo $game->get_release_date(); ?></div>
                        <div id="rating_div" class="rating_div"><?php echo $game->get_rating(); ?></div>
                        <div id="game_id" class="game_id"><?php echo $game->get_id(); ?></div>
                        <form method="post">
                            <input type="hidden" name="game_id" value="<?php echo $game->get_id(); ?>">
                            <?php if ($isFavorited) { ?>
                                <button type="submit" name="unfavorite" class="btn btn-danger">Unfavorite</button>
                            <?php } else { ?>
                                <button type="submit" name="favorite" class="btn btn-primary">Favorite</button>
                            <?php } ?>
                        </form>
                    </div>

                    <?php
                    
                }

            ?>


            
           








            

        </div>

        
        <div id="Detailpage" style='display: none;'> 
                <div id="DetailPage_Description" class="DetailPage_Description"></div>
                <div id="DetailPage_Genre" class="DetailPage_Genre"></div>
                <div id="DetailPage_Platform" class="DetailPage_Platform"></div>
                <div id="DetailPage_ReleaseYear" class="DetailPage_ReleaseYear"></div>
                <div id="DetailPage_Rating" class="DetailPage_Rating"></div>
        </div>


        <div id="myForm" style='display: none;'>
            <form id="myActualForm" method="post" enctype="multipart/form-data">

            <br>
            <br>
            <br>
            <label class="labelThingy">Title:</label>
               <input type="text" name="Title" class="forumThingy">
            <br>
            <br>
            
            <label class="labelThingy">Genre:</label>
               <input type="text" name="Genre" class="forumThingy">
            <br>
            <br>

            <label class="labelThingy">Platform:</label>
               <input type="text" name="Platform" class="forumThingy">
            <br>
            <br>

            <label class="labelThingy" for="Release_Year" >Release Year:</label>
               <input type="date" name="Release_Year" class="forumThingy">
            <br>
            <br>
            
            <label class="labelThingy">Rating(1/10):</label>
               <input type="text" name="Rating" class="forumThingy">
            <br>
            <br>

            <label class="labelThingy">Description:</label>
               <input type="text" name="Description" class="forumThingy">
            <br>
            <br>

            <label class="labelThingy">GameIcon:</label>
               <input type="file" name="GameIcon" id="GameIcon" class="GameIcon">
            <br>
            <br>

            <label class="labelThingyCustom">GameBackgroundIcon:</label>
               <input type="file" name="GameBackgroundIcon" id="GameBackgroundIcon" class="GameBackgroundIcon">
            <br>
            <br>
            <input type="submit" class="submitThingy">

            </form>






        </div>


    </div>

   <script src="javascript.js" type="text/javascript"></script>

</body>
</html>