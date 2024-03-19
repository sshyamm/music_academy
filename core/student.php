<?php
class Student{
    private $conn;
    private $table = "students";
    private $table_teach = "teachers";

    public $user_parent_id;
    public $user_name;
    public $phone_num;
    public $email;
    public $age_group_parent_id;
    public $course_parent_id;
    public $level_parent_id;
    public $emergency_contact;
    public $blood_group;
    public $address;
    public $pincode;
    public $city_parent_id;
    public $state_parent_id;
    public $country_parent_id;
    public $teacher_phone;
    public $teacher_email;
    public $qualification;
    public $teacher_exp;
    public $teacher_address;

    public function __construct($db){
        $this->conn = $db;
    }

    public function createStudent() {
        $duplicate_stmt = $this->conn->prepare("SELECT * FROM users WHERE user_name = :user_name");
        $duplicate_stmt->bindParam(':user_name', $this->user_name);
        $duplicate_stmt->execute();
    
        if ($duplicate_stmt->rowCount() > 0) {
            echo json_encode(array('error' => 'Username already exists'));
            exit();
        }
    
        $insert_user_stmt = $this->conn->prepare("INSERT INTO users (user_name, user_password) VALUES (:user_name, :user_password)");
        $insert_user_stmt->bindParam(':user_name', $this->user_name);
        $insert_user_stmt->bindParam(':user_password', $this->user_password); 
    
        if ($insert_user_stmt->execute()) {
            $user_id = $this->conn->lastInsertId();
    
            $insert_student_stmt = $this->conn->prepare("INSERT INTO students (user_parent_id) VALUES (:user_id)");
            $insert_student_stmt->bindParam(':user_id', $user_id);
    
            if ($insert_student_stmt->execute()) {
                return true;
            } else {
                return json_encode(array('error' => 'Failed to create student'));
            }
        } else {
            return json_encode(array('error' => 'Failed to create user'));
        }
    }
    
    public function updateStudent() {
        $check_stmt = $this->conn->prepare("SELECT * FROM students WHERE user_parent_id = :user_parent_id");
        $check_stmt->bindParam(':user_parent_id', $this->user_parent_id);
        $check_stmt->execute();
        
        if ($check_stmt->rowCount() === 0) {
            echo json_encode(array('error' => 'Student does not exist'));
            exit();
        }
    
        $duplicate_stmt = $this->conn->prepare("SELECT * FROM users WHERE user_name = :user_name AND user_id != :user_id");
        $duplicate_stmt->bindParam(':user_name', $this->user_name);
        $duplicate_stmt->bindParam(':user_id', $this->user_parent_id);
        $duplicate_stmt->execute();
    
        if ($duplicate_stmt->rowCount() > 0) {
            echo json_encode(array('error' => 'Username already exists'));
            exit();
        }
    
        $update_stmt = $this->conn->prepare("UPDATE students s
                          LEFT JOIN users u ON s.user_parent_id = u.user_id
                          SET u.user_name = :user_name, s.phone_num = :phone_num, s.email = :email, s.age_group_parent_id = :age_group_parent_id, s.course_parent_id = :course_parent_id, s.level_parent_id = :level_parent_id, s.emergency_contact = :emergency_contact, s.blood_group = :blood_group, s.address = :address, s.pincode = :pincode, s.city_parent_id = :city_parent_id, s.state_parent_id = :state_parent_id, s.country_parent_id = :country_parent_id
                          WHERE s.user_parent_id = :user_parent_id");
        $update_stmt->bindParam(':user_name', $this->user_name);
        $update_stmt->bindParam(':phone_num', $this->phone_num);
        $update_stmt->bindParam(':email', $this->email);
        $update_stmt->bindParam(':age_group_parent_id', $this->age_group_parent_id);
        $update_stmt->bindParam(':course_parent_id', $this->course_parent_id);
        $update_stmt->bindParam(':level_parent_id', $this->level_parent_id);
        $update_stmt->bindParam(':emergency_contact', $this->emergency_contact);
        $update_stmt->bindParam(':blood_group', $this->blood_group);
        $update_stmt->bindParam(':address', $this->address);
        $update_stmt->bindParam(':pincode', $this->pincode);
        $update_stmt->bindParam(':city_parent_id', $this->city_parent_id);
        $update_stmt->bindParam(':state_parent_id', $this->state_parent_id);
        $update_stmt->bindParam(':country_parent_id', $this->country_parent_id);
        $update_stmt->bindParam(':user_parent_id', $this->user_parent_id);
    
        $update_stmt->execute();
    
        if ($update_stmt->rowCount() > 0) {
            return true;
        } else {
            return json_encode(array('error' => 'Failed to update student details'));
        }
    }

    public function updateTeacher(){
        $check_stmt = $this->conn->prepare("SELECT * FROM $this->table_teach WHERE user_parent_id = :user_parent_id");
        $check_stmt->bindParam(':user_parent_id', $this->user_parent_id);
        $check_stmt->execute();
        
        if ($check_stmt->rowCount() === 0) {
            return array('error' => 'Teacher does not exist');
        }
    
        $duplicate_stmt = $this->conn->prepare("SELECT * FROM users WHERE user_name = :user_name AND user_id != :user_id");
        $duplicate_stmt->bindParam(':user_name', $this->user_name);
        $duplicate_stmt->bindParam(':user_id', $this->user_parent_id);
        $duplicate_stmt->execute();
    
        if ($duplicate_stmt->rowCount() > 0) {
            return array('error' => 'Teacher name already exists');
        }
    
        $update_stmt = $this->conn->prepare("UPDATE $this->table_teach s
                          LEFT JOIN users u ON s.user_parent_id = u.user_id
                          SET u.user_name = :user_name, s.teacher_phone = :teacher_phone, s.teacher_email = :teacher_email, s.qualification = :qualification, s.course_parent_id = :course_parent_id, s.teacher_exp = :teacher_exp, s.teacher_address = :teacher_address
                          WHERE s.user_parent_id = :user_parent_id");
        $update_stmt->bindParam(':user_name', $this->user_name);
        $update_stmt->bindParam(':teacher_phone', $this->teacher_phone);
        $update_stmt->bindParam(':teacher_email', $this->teacher_email);
        $update_stmt->bindParam(':qualification', $this->qualification);
        $update_stmt->bindParam(':course_parent_id', $this->course_parent_id);
        $update_stmt->bindParam(':teacher_exp', $this->teacher_exp);
        $update_stmt->bindParam(':teacher_address', $this->teacher_address);
    
        $update_stmt->execute();
    
        if ($update_stmt->rowCount() > 0) {
            return true;
        } else {
            return array('error' => 'Failed to update teacher details');
        }
    }
}
?>
