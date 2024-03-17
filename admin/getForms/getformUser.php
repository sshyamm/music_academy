<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionUser = isset($_POST['actionUser']) ? $_POST['actionUser'] : '';

    switch ($actionUser) {
        case 'create_mode_user':
            $user_name = $_POST['user_name'];
            $user_password = $_POST['user_password'];
            $user_type = $_POST['user_type'];
            $user_status = $_POST['user_status'];

            $sql = "INSERT INTO users (user_name, user_password, user_type, user_status)
                    VALUES ('$user_name', '$user_password', '$user_type', '$user_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'User created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_user':
            $user_id = $_POST['user_id']; 
            $user_name = $_POST['user_name'];
            $user_password = $_POST['user_password'];
            $user_type = $_POST['user_type'];
            $user_status = $_POST['user_status'];

            $sql = "UPDATE users SET user_name='$user_name', user_password='$user_password', user_type='$user_type',user_status='$user_status' WHERE user_id=$user_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'User updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_user':
            $user_id = $_POST['user_id'];
            $sql = "DELETE FROM users WHERE user_id=$user_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'User deleted successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        default:
            $response = array('success' => false, 'message' => 'Invalid action');
            break;
    }

    $conn->close();

    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>
