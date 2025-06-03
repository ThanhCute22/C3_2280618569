<?php
class AccountModel {
    private $conn;
    private $table_name = "account";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAccountByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function save($username, $fullName, $email, $phone, $password, $avatar = null, $role = 'user') {
        if ($this->getAccountByUsername($username)) {
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, fullname=:fullname, email=:email, phone=:phone, password=:password, avatar=:avatar, role=:role";
        $stmt = $this->conn->prepare($query);
        $username = htmlspecialchars(strip_tags($username));
        $fullName = htmlspecialchars(strip_tags($fullName));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $avatar = $avatar ? htmlspecialchars(strip_tags($avatar)) : null;
        $role = htmlspecialchars(strip_tags($role));
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":fullname", $fullName);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":avatar", $avatar);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }

    public function getAllUsers() {
        $query = "SELECT username, fullname, email, phone, avatar, role FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUserByUsername($username) {
        $query = "SELECT username, fullname, email, phone, avatar, role FROM " . $this->table_name . " WHERE username = :username LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateUser($username, $fullName, $email, $phone, $password, $avatar, $role) {
        if ($password) {
            $query = "UPDATE " . $this->table_name . " SET fullname = :fullname, email = :email, phone = :phone, password = :password, avatar = :avatar, role = :role WHERE username = :username";
            $stmt = $this->conn->prepare($query);
            $password = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password);
        } else {
            $query = "UPDATE " . $this->table_name . " SET fullname = :fullname, email = :email, phone = :phone, avatar = :avatar, role = :role WHERE username = :username";
            $stmt = $this->conn->prepare($query);
        }
        $username = htmlspecialchars(strip_tags($username));
        $fullName = htmlspecialchars(strip_tags($fullName));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $avatar = $avatar ? htmlspecialchars(strip_tags($avatar)) : null;
        $role = htmlspecialchars(strip_tags($role));
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":fullname", $fullName);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":avatar", $avatar);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }

    public function deleteUser($username) {
        $query = "DELETE FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        return $stmt->execute();
    }
}
?>