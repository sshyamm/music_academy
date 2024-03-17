<?php
    include("../db.php");
    $sql = "SELECT t.*, 
    u.user_name AS assigned_to_name,
    te.user_name AS assigned_by_name
    FROM tasks t
    LEFT JOIN users u ON t.assigned_to = u.user_id
    LEFT JOIN users te ON t.assigned_by = te.user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Task title</th><th>Task Description</th><th>Assigned To</th><th>Assigned By</th><th>Deadline</th><th>Priority</th><th>Created At</th><th>Updated At</th><th>Estimated Hours</th><th>File Path</th><th>Task Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['task_id']}</td>";
            echo "<td>{$row['task_title']}</td>";
            echo "<td>{$row['task_desc']}</td>";
            echo "<td>{$row['assigned_to_name']}</td>";
            echo "<td>{$row['assigned_by_name']}</td>";
            echo "<td>{$row['deadline']}</td>";
            echo "<td>{$row['priority']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['updated_at']}</td>";
            echo "<td>{$row['estimated_hours']}</td>";
            echo "<td>{$row['file_path']}</td>";
            echo "<td>{$row['task_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormTask('edit_mode_task', {$row['task_id']})\">Edit</button>";
            echo "<button onclick=\"showFormTask('delete_mode_task', {$row['task_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No tasks found."; 
    }

    $conn->close();
?>