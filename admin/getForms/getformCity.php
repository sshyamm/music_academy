<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionCity = isset($_POST['actionCity']) ? $_POST['actionCity'] : '';

    switch ($actionCity) {
        case 'create_mode_city':
            $state_parent_id = $_POST['state_parent_id'];
            $city_name = $_POST['city_name'];
            $city_status = $_POST['city_status'];

            $sql = "INSERT INTO cities (state_parent_id, city_name, city_status)
                    VALUES ('$state_parent_id', '$city_name', '$city_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'City created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_city':
            $state_parent_id = $_POST['state_parent_id'];
            $city_id = $_POST['city_id']; 
            $city_name = $_POST['city_name'];
            $city_status = $_POST['city_status'];

            $sql = "UPDATE cities SET state_parent_id='$state_parent_id', city_name='$city_name', city_status='$city_status' WHERE city_id=$city_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'City updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_city':
            $city_id = $_POST['city_id'];
            $sql = "DELETE FROM cities WHERE city_id=$city_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'City deleted successfully!!');
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
