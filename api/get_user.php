<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../includes/config.php'; 
require_once '../core/profile.php'; 

$data = (array) json_decode(file_get_contents('php://input'), true) + $_POST;

if (isset($data['user_name'], $data['user_password'])) {
    $user = new Profile($db); 
    $user->user_name = $data['user_name'];
    $user->user_password = $data['user_password'];

    $result = $user->checkUser();
} else {
    echo json_encode(array('error' => 'Please provide both username and password'));
    exit; 
}

if (isset($result)) {
    if ($result['success']) {
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_name'] = $result['user_name'];
        echo json_encode(array('Message' => 'Logged in successfully with ID: ' . $result['user_id'] . ' and name: ' . $result['user_name']));
    } else {
        echo json_encode(array('error' => $result['error']));
    }
} else {
    echo json_encode(array('error' => 'Invalid data'));
    exit;
}
?>