<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/student.php';

$student = new Student($db);

$user_parent_id = isset($_POST['user_parent_id']) ? $_POST['user_parent_id'] : null;
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : null;
$phone_num = isset($_POST['phone_num']) ? $_POST['phone_num'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$age_group_parent_id = isset($_POST['age_group_parent_id']) ? $_POST['age_group_parent_id'] : null;
$course_parent_id = isset($_POST['course_parent_id']) ? $_POST['course_parent_id'] : null;
$level_parent_id = isset($_POST['level_parent_id']) ? $_POST['level_parent_id'] : null;
$emergency_contact = isset($_POST['emergency_contact']) ? $_POST['emergency_contact'] : null;
$blood_group = isset($_POST['blood_group']) ? $_POST['blood_group'] : null;
$address = isset($_POST['address']) ? $_POST['address'] : null;
$pincode = isset($_POST['pincode']) ? $_POST['pincode'] : null;
$city_parent_id = isset($_POST['city_parent_id']) ? $_POST['city_parent_id'] : null;
$state_parent_id = isset($_POST['state_parent_id']) ? $_POST['state_parent_id'] : null;
$country_parent_id = isset($_POST['country_parent_id']) ? $_POST['country_parent_id'] : null;

$student->user_parent_id = $user_parent_id;
$student->user_name = $user_name;
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
    echo json_encode(array('Message'=>'Error occurred in updating')); 
}
?>
