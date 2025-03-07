<?php 

if (!isset($_SESSION)) {
    session_start();
}

ob_start();


class Database {
    private $servername = "mysql";
    private $username = "root";
    private $password = "root";
    private $dbname = "database";

    private $stmt;
    private $conn;
        
    public function create_connection () {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function register($username, $userpassword, $email) {
        echo "TEST";
        // hash
        $userpassword = password_hash($userpassword, PASSWORD_DEFAULT);
        //hash

        $this->stmt = $this->conn->prepare("INSERT INTO user_login (username, password, email) VALUES (?, ?, ?)");
        $this->stmt->bind_param("sss", $username, $userpassword, $email);
    
        if ($this->stmt->execute()) {
             echo "Succesfully send";
        } else {
           echo "Something went wrong?";
        }


        $this->stmt->close();
    }

    public function GatherGames($user_id) {
        $query = "SELECT Game.title
        FROM Game
        INNER JOIN user_games ON Game.id = user_games.game_id
        WHERE user_games.user_id = ?";
        $this->stmt = $this->conn->prepare($query);
        $this->stmt->bind_param("i", $user_id);
        $this->stmt->execute();
        $result = $this->stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function GetUserId($username) {
        $query = "SELECT id FROM user_login WHERE username = ?";
        $this->stmt = $this->conn->prepare($query);
        $this->stmt->bind_param("s", $username);
        $this->stmt->execute();
        $this->stmt->store_result();
        $this->stmt->bind_result($userid);
        $this->stmt->fetch();
        $this->stmt->close();
        return $userid;

        
    }

    public function login($username, $userpassword) {
        // echo "<br>";
        // echo $userpassword;
        // echo "<br>";
        // hash
        // $userpassword = password_hash($userpassword, PASSWORD_DEFAULT);
        //hash
        $this->stmt = $this->conn->prepare("SELECT password FROM user_login WHERE username = ?");
        $this->stmt->bind_param("s", $username);
        $this->stmt->execute();
        $this->stmt->store_result();
        
        if ($this->stmt->num_rows > 0) {
            $this->stmt->bind_result($password);
            $this->stmt->fetch();
            $test = password_verify($userpassword, $password);
            if($test == true) {
                echo "Password is valid";
                $_SESSION["logged"] = TRUE;
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $userpassword;
                $_SESSION["user_id"] = $this->GetUserId($username);
                header("Location: index.php");
                ob_end_flush();
                die();
            } else {
               echo "Invalid password";     
            }

        } else {
            // echo "No user found";
        }

        $this->stmt->close();
    }

    public function send_data($title, $genre, $platform, $Release_Year, $rating, $description, $gameicon, $gamebackgroundicon) {
        
        //Eerst statement klaarzetten
        //dan pas data binden met bind_param
        //Om SQL injectie te voorkomen
        $this->stmt = $this->conn->prepare("INSERT INTO Game (title, genre, platform, release_year, rating, description, game_icon, game_background_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $this->stmt->bind_param("ssssssss", $title, $genre, $platform, $Release_Year, $rating, $description, $gameicon, $gamebackgroundicon);
    
        if ($this->stmt->execute()) {
             echo "Succesfully send";
        } else {
           echo "Something went wrong?";
        }


        $this->stmt->close();

    }

}

?>