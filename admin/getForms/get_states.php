<?php
require_once("../db.php");
echo "<option value=''>Select State</option>";
if(isset($_POST['country_parent_id'])) {
    $country_parent_id = $_POST['country_parent_id'];
    
    $state_sql = "SELECT * FROM states WHERE country_parent_id = $country_parent_id";
    $state_result = $conn->query($state_sql);

    if ($state_result->num_rows > 0) {
        while ($state_row = $state_result->fetch_assoc()) {
            echo "<option value='" . $state_row['state_id'] . "'>" . $state_row['state_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No states available</option>";
    }
}
?>
