<?php 

class GameManager {
    
    
    public $TitleRegex = "/^.{1,100}$/";
    public $GenreRegex = "/^.{1,30}$/";
    public $PlatformRegex = "/^.{1,20}$/";
    public $RatingRegex = "/\b([1-9]|10)\b/";
    public $DescriptionRegex = "/^.{1,1000}$/";
    public $GameIconRegex = "/^.{1,99}$/";
    public $GameBackgroundIconRegex = "/^.{1,99}$/";

    private $db_itself;

    public function __construct(Database $db) {
        $this->db_itself = $db;
    }

    //filteren van data
    //voorkomen van XSS attack (cross site scripting)
    public function condoom ($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    public function  login($username, $password) {
        $username = $this->condoom($username);
        $password = $this->condoom($password);

        $this->db_itself->send_data($username, $password);
    }



    public function fileUpload($file) {
    
        //check and upload GAMEICON image   
        $target_dir = '../../items/';
        $fileName= $file["name"];


        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        
        // Check file size
        if ($file["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
            } else {
            echo "Sorry, there was an error uploading your file.";
            }
        }

      

    }

    public function insertGame ($data, $GameIcon, $GameBackgroundIcon) {

        $AllowedToContinue = true;
        $title = $data["Title"];
        $genre = $data["Genre"];
        $platform = $data["Platform"];
        $release_year = $data["Release_Year"];
        $rating = $data["Rating"];
        $description = $data["Description"];
        $gameIcon = $GameIcon;
        $gameBackgroundIcon = $GameBackgroundIcon;

        $title = $this->condoom($title);
        
        $genre = $this->condoom($genre);
        
        $platform = $this->condoom($platform);
        
        $release_year = $this->condoom($release_year);
        
        $rating = $this->condoom($rating);
        
        $description = $this->condoom($description);
        
        $gameIcon = $this->condoom($gameIcon);
                
        $gameBackgroundIcon = $this->condoom($gameBackgroundIcon);


        if (!preg_match($this->TitleRegex, $title)) {
            $AllowedToContinue = false;
        }

        if (!preg_match($this->GenreRegex, $genre)) {
            $AllowedToContinue = false;
        }

        if (!preg_match($this->PlatformRegex, $platform)) {
            $AllowedToContinue = false;
        }

        if (!preg_match($this->RatingRegex, $rating)) {
            $AllowedToContinue = false;
        }

        if (!preg_match($this->DescriptionRegex, $description)) {
            $AllowedToContinue = false;
        }

        if (!preg_match($this->GameIconRegex, $GameIcon)) {
            $AllowedToContinue = false;
        }

        if (!preg_match($this->GameBackgroundIconRegex, $GameBackgroundIcon)) {
            $AllowedToContinue = false;
        }


        if ($AllowedToContinue == true) {

            $this->db_itself->send_data($title, $genre, $platform, $release_year, $rating, $description, $GameIcon, $GameBackgroundIcon);

        } else {
            echo "An error occured, Perhaps you have reached the character limit?";
        }

    }

    public function getAllGames() {
        // Get the database connection
        $conn = $this->db_itself->getConnection();
        
        // Initialize an empty array to hold game objects
        $games = [];
    
        // Prepare SQL query
        $sql = "SELECT * FROM Game";
    
        try {
            // Prepare the query using mysqli
            $stmt = $conn->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Error preparing statement: " . $conn->error);
            }
            
            // Execute the prepared statement
            $stmt->execute();
            
            // Fetch the result set
            $result = $stmt->get_result();
            
            // Loop through each row in the result set
            while ($row = $result->fetch_assoc()) {
                // Create a new Game object with data from the current row
                $game = new Game(
                    $row['title'],
                    $row['genre'],
                    $row['platform'],
                    $row['release_year'],
                    $row['rating'],
                    $row['description'],
                    $row['game_icon'],
                    $row['game_background_image']
                );
    
                // Add the Game object to the $games array
                $games[] = $game;
            }
    
            // Free the result and close the statement
            $result->free();
            $stmt->close();
        } catch (Exception $e) {
            // Handle any potential
        }

        return $games;

    }
    
}

?>