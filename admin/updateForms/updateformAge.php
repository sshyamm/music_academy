<?php
include("../db.php");

$sql = "SELECT * FROM age_groups";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Age group</th><th>Age group status</th><th>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['age_group_id']}</td>";
        echo "<td>{$row['age_group_name']}</td>";
        echo "<td>{$row['age_group_status']}</td>";
        echo "<td>";
        echo "<button onclick=\"showFormAge('edit_mode_age', {$row['age_group_id']})\">Edit</button>";
        echo "<button onclick=\"showFormAge('delete_mode_age', {$row['age_group_id']})\">Delete</button>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No ages found.";
}

$conn->close();
?>
