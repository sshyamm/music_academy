<?php
    include("../db.php");
    $sql = "SELECT Ro.*, 
               d.date_of_class,
	       us.user_name
        FROM class_rooms Ro
        LEFT JOIN classes d ON Ro.class_parent_id = d.class_id
	LEFT JOIN users us ON Ro.user_parent_id = us.user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Class</th><th>Student</th><th>Attendance</th><th>Attendance Time</th><th>Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['class_room_id']}</td>";
            echo "<td>{$row['date_of_class']}</td>";
            echo "<td>{$row['user_name']}</td>";
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