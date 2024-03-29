<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/student.php';

$student = new Student($db);

$student->user_name = $_POST['user_name'];
$student->user_password = $_POST['user_password'];

$result = $student->createStudent();
if($result === true){
    echo json_encode(array('Message'=>'User created successfully'));
} else {
    echo json_encode(array('Message'=>'Error occured in creating')); 
}
?>