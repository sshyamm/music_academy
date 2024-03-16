<?php
include("../db.php");

$sql = "SELECT s.*, 
          co.country_name
    FROM states s
    LEFT JOIN countries co ON s.country_parent_id = co.country_id";
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Country</th><th>State Name</th><th>State Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['state_id']}</td>";
            echo "<td>{$row['country_name']}</td>";
            echo "<td>{$row['state_name']}</td>";
            echo "<td>{$row['state_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormState('edit_mode_state', {$row['state_id']})\">Edit</button>";
            echo "<button onclick=\"showFormState('delete_mode_state', {$row['state_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No states found."; 
    }

$conn->close();
?>
