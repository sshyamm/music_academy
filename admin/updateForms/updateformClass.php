<?php
    include("../db.php");
    $sql = "SELECT ti.*, 
               c.course_name,
	       us.user_name
        FROM classes ti
        LEFT JOIN courses c ON ti.course_parent_id = c.course_id
	LEFT JOIN users us ON ti.user_parent_id = us.user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Course</th><th>Teacher</th><th>Start Time</th><th>End Time</th><th>Date</th><th>Created At</th><th>Updated At</th><th>Class Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['class_id']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['sched_start_time']}</td>";
            echo "<td>{$row['sched_end_time']}</td>";
            echo "<td>{$row['date_of_class']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['updated_at']}</td>";
            echo "<td>{$row['class_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormClass('edit_mode_class', {$row['class_id']})\">Edit</button>";
            echo "<button onclick=\"showFormClass('delete_mode_class', {$row['class_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No class found."; 
    }

    $conn->close();
    ?>