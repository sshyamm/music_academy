<?php
include("../db.php");

$sql = "SELECT * FROM levels";
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Level Name</th><th>Level Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['level_id']}</td>";
            echo "<td>{$row['level_name']}</td>";
            echo "<td>{$row['level_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormLevel('edit_mode_level', {$row['level_id']})\">Edit</button>";
            echo "<button onclick=\"showFormLevel('delete_mode_level', {$row['level_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No Levels found."; 
    }

$conn->close();
?>
