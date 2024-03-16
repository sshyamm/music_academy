<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionCountry = isset($_POST['actionCountry']) ? $_POST['actionCountry'] : '';

    switch ($actionCountry) {
        case 'create_mode_country':
            $country_name = $_POST['country_name'];
            $country_status = $_POST['country_status'];

            $sql = "INSERT INTO countries (country_name, country_status)
                    VALUES ('$country_name', '$country_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Country created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_country':
            $country_id = $_POST['country_id']; 
            $country_name = $_POST['country_name'];
            $country_status = $_POST['country_status'];

            $sql = "UPDATE countries SET country_name='$country_name', country_status='$country_status' WHERE country_id=$country_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Country updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_country':
            $country_id = $_POST['country_id'];
            $sql = "DELETE FROM countries WHERE country_id=$country_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Country deleted successfully!!');
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
