<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionState = isset($_POST['actionState']) ? $_POST['actionState'] : '';

    switch ($actionState) {
        case 'create_mode_state':
            $country_parent_id = $_POST['country_parent_id'];
            $state_name = $_POST['state_name'];
            $state_status = $_POST['state_status'];

            $sql = "INSERT INTO states (country_parent_id, state_name, state_status)
                    VALUES ('$country_parent_id', '$state_name', '$state_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'State created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_state':
            $state_id = $_POST['state_id']; 
           $country_parent_id = $_POST['country_parent_id'];
            $state_name = $_POST['state_name'];
            $state_status = $_POST['state_status'];

            $sql = "UPDATE states SET country_parent_id='$country_parent_id', state_name='$state_name', state_status='$state_status' WHERE state_id=$state_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'State updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_state':
            $state_id = $_POST['state_id'];
            $sql = "DELETE FROM states WHERE state_id=$state_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'State deleted successfully!!');
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
