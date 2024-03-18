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
        if ($this->user_password === $row['user_password']) {
            return array('success' => true, 'user_id' => $row['user_id'], 'user_name' => $row['user_name'], 'user_type' => $row['user_type']);
        } else {
            return array('success' => false, 'error' => 'Invalid password. Try again');
        }
    }
}
?>