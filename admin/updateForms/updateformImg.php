<?php
    include("../db.php");
    $sql = "SELECT * FROM images";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Image Name</th><th>Image Path</th><th>Image Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['image_id']}</td>";
            echo "<td>{$row['image_name']}</td>";
            echo "<td><img src='getForms/img/{$row['image_path']}' alt='Image'></td>";
            echo "<td>{$row['image_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormImg('edit_mode_img', {$row['image_id']})\">Edit</button>";
            echo "<button onclick=\"showFormImg('delete_mode_img', {$row['image_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No images found."; 
    }

    $conn->close();
?>