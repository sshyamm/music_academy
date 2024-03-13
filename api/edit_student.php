<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/student.php';

$student = new Student($db);

$student_id = $_POST['student_id'] ?? null;
$student_username = $_POST['student_username'] ?? null;
$phone_num = $_POST['phone_num'] ?? null;
$email = $_POST['email'] ?? null;
$age_group_parent_id = $_POST['age_group_parent_id'] ?? null;
$course_parent_id = $_POST['course_parent_id'] ?? null;
$level_parent_id = $_POST['level_parent_id'] ?? null;
$emergency_contact = $_POST['emergency_contact'] ?? null;
$blood_group = $_POST['blood_group'] ?? null;
$address = $_POST['address'] ?? null;
$pincode = $_POST['pincode'] ?? null;
$city_parent_id = $_POST['city_parent_id'] ?? null;
$state_parent_id = $_POST['state_parent_id'] ?? null;
$country_parent_id = $_POST['country_parent_id'] ?? null;

$student->student_id = $student_id;
$student->student_username = $student_username;
$student->phone_num = $phone_num;
$student->email = $email;
$student->age_group_parent_id = $age_group_parent_id;
$student->course_parent_id = $course_parent_id;
$student->level_parent_id = $level_parent_id;
$student->emergency_contact = $emergency_contact;
$student->blood_group = $blood_group;
$student->address = $address;
$student->pincode = $pincode;
$student->city_parent_id = $city_parent_id;
$student->state_parent_id = $state_parent_id;
$student->country_parent_id = $country_parent_id;

$result = $student->updateStudent();
if($result === true){
    echo json_encode(array('Message'=>'Student updated successfully'));
} else {
    echo json_encode(array('Message'=>'Error occured in updating')); 
}
?>