<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/student.php';

$student = new Student($db);

$student->student_username = $_POST['student_username'];
$student->student_password = $_POST['student_password'];
$student->phone_num = $_POST['phone_num'];
$student->email = $_POST['email'];
$student->age_group_parent_id = $_POST['age_group_parent_id'];
$student->course_parent_id = $_POST['course_parent_id'];
$student->level_parent_id = $_POST['level_parent_id'];
$student->emergency_contact = $_POST['emergency_contact'];
$student->blood_group = $_POST['blood_group'];
$student->address = $_POST['address'];
$student->pincode = $_POST['pincode'];
$student->city_parent_id = $_POST['city_parent_id'];
$student->state_parent_id = $_POST['state_parent_id'];
$student->country_parent_id = $_POST['country_parent_id'];
$student->student_status = $_POST['student_status'];

$result = $student->createStudent();
if($result === true){
    echo json_encode(array('Message'=>'Student created successfully'));
} else {
    echo json_encode(array('Message'=>'Error occured in creating')); 
}
?>