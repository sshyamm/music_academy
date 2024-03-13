<?php
require_once("includes/config.php");

echo "<option value=''>Select State</option>";

if(isset($_POST['country_parent_id'])) {
    $country_parent_id = $_POST['country_parent_id'];
    
    $state_sql = "SELECT * FROM states WHERE country_parent_id = ?";
    $state_stmt = $db->prepare($state_sql);
    $state_stmt->execute([$country_parent_id]);

    $state_result = $state_stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($state_result) > 0) {
        foreach ($state_result as $state_row) {
            echo "<option value='" . $state_row['state_id'] . "'>" . $state_row['state_name'] . "</option>";
        }
    } else {
        echo "<option value=''>No states available</option>";
    }
}
?>