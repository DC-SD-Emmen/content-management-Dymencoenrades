<?php 

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

    public function send_data($username, $userpassword) {
        print("TestZ");
        
        //Eerst statement klaarzetten
        //dan pas data binden met bind_param
        //Om SQL injectie te voorkomen

        // hash
        $userpassword = password_hash($userpassword, PASSWORD_DEFAULT);
        //hash


        $this->stmt = $this->conn->prepare("INSERT INTO Game (username, password) VALUES (?, ?)");
        $this->stmt->bind_param("ss", $username, $userpassword);
    
        if ($this->stmt->execute()) {
             echo "Succesfully send";
        } else {
           echo "Something went wrong?";
        }


        $this->stmt->close();

    }

}

?>