<?php
require_once("../db.php");
echo "<option value=''>Select City</option>";
if(isset($_POST['state'])) {
    $state = $_POST['state'];
    
    $city_sql = "SELECT * FROM cities WHERE state_parent_id = $state";
    $city_result = $conn->query($city_sql);

    if ($city_result->num_rows > 0) {
        while ($city_row = $city_result->fetch_assoc()) {
            echo "<option value='" . $city_row['city_id'] . "'>" . $city_row['city_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No cities available</option>";
    }
}
?>
