<?php
    include("../db.php");
    $sql = "SELECT Ct.*, 
               u.user_name,
	       c.course_name
        FROM comments Ct
        LEFT JOIN courses c ON Ct.course_parent_id = c.course_id
	LEFT JOIN users u ON Ct.user_parent_id = u.user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>User Name</th><th>Comment</th><th>Course Name</th><th>Created At</th><th>Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['comment_id']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['comment']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['comment_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormCmt('edit_mode_cmt', {$row['comment_id']})\">Edit</button>";
            echo "<button onclick=\"showFormCmt('delete_mode_cmt', {$row['comment_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No comments found."; 
    }

    $conn->close();
?>