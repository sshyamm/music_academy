<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php';
require_once '../core/check_user.php';

if ($_SERVER['CONTENT_TYPE'] === 'application/json' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = (array) json_decode(file_get_contents('php://input'), true) + $_POST;

    if ((isset($data['teacher_username'], $data['teacher_password']) && !isset($data['student_username'], $data['student_password']))
        || (!isset($data['teacher_username'], $data['teacher_password']) && isset($data['student_username'], $data['student_password']))) {
        
        $user = new User($db);

        if (isset($data['teacher_username'], $data['teacher_password'])) {
            $user->teacher_username = $data['teacher_username'];
            $user->teacher_password = $data['teacher_password'];

            $result = $user->checkTeacher();
        } elseif (isset($data['student_username'], $data['student_password'])) {
            $user->student_username = $data['student_username'];
            $user->student_password = $data['student_password'];

            $result = $user->checkStudent();
        }

        if (isset($result)) {
            if ($result === true) {
                echo json_encode(array('Message' => 'Logged in successfully'));
            } elseif ($result === 'invalid_password') {
                echo json_encode(array('error' => 'Invalid password. Try again'));
            } else {
                echo json_encode(array('error' => 'User does not exist'));
            }
        } else {
            echo json_encode(array('error' => 'Invalid data'));
            exit;
        }
    } else {
        echo json_encode(array('error' => 'Invalid data or field'));
        exit;
    }
} else {
    echo json_encode(array('error' => 'Unsupported request method or content type'));
}
?>
