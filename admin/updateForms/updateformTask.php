<?php
    include("../db.php");
    $sql = "SELECT t.*, 
    u.user_name,
    ct.task_desc
    FROM tasks t
    LEFT JOIN users u ON t.user_parent_id = u.user_id
    LEFT JOIN class_tasks ct ON t.task_parent_id = ct.task_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Task Description</th><th>Student Name</th><th>Remark</th><th>Comment</th><th>File Path</th><th>Grading</th><th>Last Updated</th><th>Submit Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['task_manager_id']}</td>";
            echo "<td>{$row['task_desc']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['remark']}</td>";
            echo "<td>{$row['comment']}</td>";
            echo "<td>{$row['file_path']}</td>";
            echo "<td>{$row['grading']}</td>";
            echo "<td>{$row['last_updated']}</td>";
            echo "<td>{$row['submit_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormTask('edit_mode_task', {$row['task_manager_id']})\">Edit</button>";
            echo "<button onclick=\"showFormTask('delete_mode_task', {$row['task_manager_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No tasks found."; 
    }

    $conn->close();
    ?>