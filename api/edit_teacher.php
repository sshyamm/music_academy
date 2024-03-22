<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/student.php';

$teacher = new Student($db);

$user_parent_id = isset($_POST['user_parent_id']) ? $_POST['user_parent_id'] : null;
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : null;
$teacher_phone = isset($_POST['teacher_phone']) ? $_POST['teacher_phone'] : null;
$teacher_email = isset($_POST['teacher_email']) ? $_POST['teacher_email'] : null;
$qualification = isset($_POST['qualification']) ? $_POST['qualification'] : null;
$course_parent_id = isset($_POST['course_parent_id']) ? $_POST['course_parent_id'] : null;
$teacher_exp = isset($_POST['teacher_exp']) ? $_POST['teacher_exp'] : null;
$teacher_address = isset($_POST['teacher_address']) ? $_POST['teacher_address'] : null;

$teacher->user_parent_id = $user_parent_id;
$teacher->user_name = $user_name;
$teacher->teacher_phone = $teacher_phone;
$teacher->teacher_email = $teacher_email;
$teacher->qualification = $qualification;
$teacher->course_parent_id = $course_parent_id;
$teacher->teacher_exp = $teacher_exp;
$teacher->teacher_address = $teacher_address;

$result = $teacher->updateTeacher();
if($result === true){
    echo json_encode(array('Message'=>'Teacher updated successfully'));
} else {
    echo json_encode(array('error'=>'Error occurred in updating teacher details')); 
}
?>
