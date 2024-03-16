<?php
include("../db.php");

$sql = "SELECT * FROM countries";
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Level Name</th><th>Level Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['country_id']}</td>";
            echo "<td>{$row['country_name']}</td>";
            echo "<td>{$row['country_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormCountry('edit_mode_country', {$row['country_id']})\">Edit</button>";
            echo "<button onclick=\"showFormCountry('delete_mode_country', {$row['country_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No Countries found."; 
    }

$conn->close();
?>
