<?php
    include("../db.php");
    $sql = "SELECT Ro.*, 
               d.date_of_class,
	       s.student_username
        FROM class_rooms Ro
        LEFT JOIN classes d ON Ro.class_parent_id = d.class_id
	LEFT JOIN students s ON Ro.student_parent_id = s.student_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Class</th><th>Student</th><th>Attendance</th><th>Attendance Time</th><th>Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['class_room_id']}</td>";
            echo "<td>{$row['date_of_class']}</td>";
            echo "<td>{$row['student_username']}</td>";
            echo "<td>{$row['attendance']}</td>";
            echo "<td>{$row['attendance_time']}</td>";
            echo "<td>{$row['class_room_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormPhase('edit_mode_phase', {$row['class_room_id']})\">Edit</button>";
            echo "<button onclick=\"showFormPhase('delete_mode_phase', {$row['class_room_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No rooms found."; 
    }

    $conn->close();
?>