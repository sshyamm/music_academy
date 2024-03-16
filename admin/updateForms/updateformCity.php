<?php
include("../db.php");
$sql = "SELECT c.*, 
           st.state_name
        FROM cities c
        LEFT JOIN states st ON c.state_parent_id = st.state_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>State</th><th>City Name</th><th>City Status</th><th>Action</th></tr>"; 
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['city_id']}</td>";
        echo "<td>{$row['state_name']}</td>";
        echo "<td>{$row['city_name']}</td>";
        echo "<td>{$row['city_status']}</td>";
        echo "<td>";
        echo "<button onclick=\"showFormCity('edit_mode_city', {$row['city_id']})\">Edit</button>";
        echo "<button onclick=\"showFormCity('delete_mode_city', {$row['city_id']})\">Delete</button>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No cities found."; 
}

$conn->close();
?>