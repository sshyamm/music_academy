<?php
    include("../db.php");
    $sql = "SELECT * FROM news";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Email</th><th>Created At</th><th>News Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['news_id']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['news_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormNews('edit_mode_news', {$row['news_id']})\">Edit</button>";
            echo "<button onclick=\"showFormNews('delete_mode_news', {$row['news_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No news found."; 
    }

    $conn->close();
?>