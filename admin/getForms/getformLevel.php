<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionLevel = isset($_POST['actionLevel']) ? $_POST['actionLevel'] : '';

    switch ($actionLevel) {
        case 'create_mode_level':
            $level_name = $_POST['level_name'];
            $level_status = $_POST['level_status'];

            $sql = "INSERT INTO levels (level_name, level_status)
                    VALUES ('$level_name', '$level_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Level created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_level':
            $level_id = $_POST['level_id']; 
            $level_name = $_POST['level_name'];
            $level_status = $_POST['level_status'];

            $sql = "UPDATE levels SET level_name='$level_name', level_status='$level_status' WHERE level_id=$level_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Level updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_level':
            $level_id = $_POST['level_id'];
            $sql = "DELETE FROM levels WHERE level_id=$level_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Level deleted successfully!!');
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
