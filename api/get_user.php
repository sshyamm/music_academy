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
} elseif (isset($data['admin_username'], $data['admin_password'])) {
    $user = new Profile($db); 
    $user->admin_username = $data['admin_username'];
    $user->admin_password = $data['admin_password'];

    $result_admin = $user->checkAdmin();
} else {
    echo json_encode(array('error' => 'Please provide both username and password'));
    exit; 
}

if (isset($result)) {
    if ($result['success']) {
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_name'] = $result['user_name'];
        $_SESSION['user_type'] = $result['user_type'];
        echo json_encode(array('Message' => 'Logged in successfully with ID: ' . $result['user_id'] . ' and name: ' . $result['user_name'] . ' and type: ' . $result['user_type']));
    } else {
        echo json_encode(array('error' => $result['error']));
    }
} elseif(isset($result_admin)){
    if ($result_admin['success']) {
        $_SESSION['admin_id'] = $result_admin['admin_id']; 
        $_SESSION['admin_username'] = $result_admin['admin_username'];
        echo json_encode(array('Message' => 'Logged in successfully with ID: ' . $result_admin['admin_id'] . ' and name: ' . $result_admin['admin_username']));
    } else {
        echo json_encode(array('error' => $result_admin['error']));
    }
} else {
    echo json_encode(array('error' => 'Invalid data'));
    exit;
}
?>
