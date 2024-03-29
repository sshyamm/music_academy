<?php
class Profile {
    private $conn;
    private $table = "users";

    public $user_id;
    public $user_name;
    public $user_password;
    public $user_type;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function checkUser() {
        $checkSql = "SELECT user_id, user_name, user_password, user_type FROM $this->table WHERE BINARY user_name = :user_name";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(":user_name", $this->user_name);
        $checkStmt->execute();
        $numRows = $checkStmt->rowCount();
        
        if ($numRows == 0) {
            return array('success' => false, 'error' => 'User does not exist');
        }
        
        $row = $checkStmt->fetch();
        
        if ($row['user_type'] === "None") {
            return array('success' => false, 'error' => 'You are not approved. Please contact admin');
        }
        
        if ($this->user_password === $row['user_password']) {
            return array('success' => true, 'user_id' => $row['user_id'], 'user_name' => $row['user_name'], 'user_type' => $row['user_type']);
        } else {
            return array('success' => false, 'error' => 'Invalid password. Try again');
        }
    }
    public function checkAdmin() {
        $checkSql = "SELECT admin_id, admin_username, admin_password FROM admins WHERE admin_username = :admin_username";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(":admin_username", $this->admin_username);
        $checkStmt->execute();
        $numRows = $checkStmt->rowCount();
        
        if ($numRows == 0) {
            return array('success' => false, 'error' => 'Admin does not exist');
        }
        
        $row = $checkStmt->fetch();
        
        if ($this->admin_password === $row['admin_password']) {
            return array('success' => true, 'admin_id' => $row['admin_id'], 'admin_username' => $row['admin_username']);
        } else {
            return array('success' => false, 'error' => 'Invalid password. Try again');
        }
    }
}
?>