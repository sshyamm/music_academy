<?php
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

    $result = $user->updateUserPassword();

    if ($result === true) {
        echo json_encode(array('Message' => 'Password updated successfully. Please login via portal.'));
    } else {
        echo json_encode(array('error' => 'Error occurred in updating password.'));
    }
} elseif (isset($data['admin_username'], $data['admin_password'])) {
    $user = new Profile($db); 
    $user->admin_username = $data['admin_username'];
    $user->admin_password = $data['admin_password'];

    $result = $user->updateAdminPassword();

    if ($result === true) {
        echo json_encode(array('Message' => 'Password updated successfully. Please login via portal.'));
    } else {
        echo json_encode(array('error' => 'Error occurred in updating password.'));
    }
} else {
    echo json_encode(array('error' => 'Please provide both username and password'));
}
?>
