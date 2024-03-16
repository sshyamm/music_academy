<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionAge = isset($_POST['actionAge']) ? $_POST['actionAge'] : '';

    switch ($actionAge) {
        case 'create_mode_age':
            $age_group_name = $_POST['age_group_name'];
            $age_group_status = $_POST['age_group_status'];

            $sql = "INSERT INTO age_groups (age_group_name, age_group_status)
                    VALUES ('$age_group_name', '$age_group_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Age-group created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_age':
            $age_group_id = $_POST['age_group_id']; 
            $age_group_name = $_POST['age_group_name'];
            $age_group_status = $_POST['age_group_status'];

            $sql = "UPDATE age_groups SET age_group_name='$age_group_name', age_group_status='$age_group_status' WHERE age_group_id=$age_group_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Age-group updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_age':
            $age_group_id = $_POST['age_group_id'];
            $sql = "DELETE FROM age_groups WHERE age_group_id=$age_group_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Age-group deleted successfully!!');
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
