<?php


if (!isset($_SESSION)) {
    session_start();
}


class UserManager {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function PreventSqlAttack ($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function addUser($username, $password, $email) {
        echo "User added2";
        $username = $this->PreventSqlAttack($username);
        $password = $this->PreventSqlAttack($password);
        $email = $this->PreventSqlAttack($email);
        $this->db->register($username, $password, $email);
    }

    public function login($username, $password) {
        echo "User tried logging in";
        $username = $this->PreventSqlAttack($username);
        $password = $this->PreventSqlAttack($password);

        $this->db->login($username, $password);
    }

    public function printUserInfo($username) {
        $username = $this->PreventSqlAttack($username);
        $query = "SELECT username, email FROM user_login WHERE username = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($username, $email);
        $stmt->fetch();
        $stmt->close();
        return ['username' => $username, 'email' => $email];
    }
}