<?php
class User{
    private $conn;
    private $table_student = "students";
    private $table_teacher = "teachers";

    public $student_id;
    public $student_username;
    public $student_password;

    public function __construct($db){
        $this->conn = $db;
    }

    public function checkStudent(){
        $checkSql = "SELECT student_id, student_password FROM $this->table_student WHERE BINARY student_username = :student_username";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(":student_username", $this->student_username);
        $checkStmt->execute();
        $numRows = $checkStmt->rowCount();
        
        if($numRows == 0) {
            return false; // User does not exist
        }

        $row = $checkStmt->fetch();
    
        if($this->student_password === $row['student_password']) {
            return true; 
        } else {
            return 'invalid_password';
        }
    }

    public function checkTeacher(){
        $checkSql = "SELECT teacher_id, teacher_password FROM $this->table_teacher WHERE BINARY teacher_username = :teacher_username";
        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bindParam(":teacher_username", $this->teacher_username);
        $checkStmt->execute();
        $numRows = $checkStmt->rowCount();
        
        if($numRows == 0) {
            return false; // User does not exist
        }

        $row = $checkStmt->fetch();
    
        if($this->teacher_password === $row['teacher_password']) {
            return true; 
        } else {
            return 'invalid_password';
        }
    }
}
?>
