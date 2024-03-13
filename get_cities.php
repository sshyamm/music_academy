<?php
require_once("includes/config.php");

echo "<option value=''>Select City</option>";

if(isset($_POST['state_parent_id'])) {
    $state_parent_id = $_POST['state_parent_id'];
    
    $city_sql = "SELECT * FROM cities WHERE state_parent_id = ?";
    $city_stmt = $db->prepare($city_sql);
    $city_stmt->execute([$state_parent_id]);

    $city_result = $city_stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($city_result) > 0) {
        foreach ($city_result as $city_row) {
            echo "<option value='" . $city_row['city_id'] . "'>" . $city_row['city_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No cities available</option>";
    }
}
?>
