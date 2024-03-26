<?php
include("../db.php");
$sql = "SELECT i.*, 
           cl.date_of_class,
           c.course_name
    FROM class_tasks i
    LEFT JOIN classes cl ON i.date_parent_id = cl.class_id
    LEFT JOIN courses c ON i.course_parent_id = c.course_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Task Description</th><th>Course Name</th><th>Date of class</th><th>Task file</th><th>Task Deadline</th><th>Task Status</th><th>Action</th></tr>"; 
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['task_id']}</td>";
        echo "<td>{$row['task_desc']}</td>";
        echo "<td>{$row['course_name']}</td>";
        echo "<td>{$row['date_of_class']}</td>";
        echo "<td>{$row['task_file']}</td>";
        echo "<td>{$row['task_deadline']}</td>";
        echo "<td>{$row['task_status']}</td>";
        echo "<td>";
        echo "<button onclick=\"showFormAssgn('edit_mode_assgn', {$row['task_id']})\">Edit</button>";
        echo "<button onclick=\"showFormAssgn('delete_mode_assgn', {$row['task_id']})\">Delete</button>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No Tasks found."; 
}

$conn->close();
?>