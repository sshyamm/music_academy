<?php
    include("../db.php");
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>User Name</th><th>User Type</th><th>User Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['user_id']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['user_type']}</td>";
            echo "<td>{$row['user_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormUser('edit_mode_user', {$row['user_id']})\">Edit</button>";
            echo "<button onclick=\"showFormUser('delete_mode_user', {$row['user_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No Users found."; 
    }

    $conn->close();
?>