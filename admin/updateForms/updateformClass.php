<?php
    include("../db.php");
    $searchCourse = isset($_POST['searchCourse']) ? $_POST['searchCourse'] : '';
    $searchTeacher = isset($_POST['searchTeacher']) ? $_POST['searchTeacher'] : '';
    $sql = "SELECT ti.*, 
               c.course_name,
	       t.teacher_username
        FROM classes ti
        LEFT JOIN courses c ON ti.course_parent_id = c.course_id
	LEFT JOIN teachers t ON ti.teacher_parent_id = t.teacher_id";

if (!empty($searchCourse) && !empty($searchTeacher)) {
    $sql .= " WHERE course_name LIKE '$searchCourse%' AND teacher_username LIKE '$searchTeacher%'";
} elseif (!empty($searchCourse)) {
    $sql .= " WHERE course_name LIKE '$searchCourse%'";
} elseif (!empty($searchName)) {
    $sql .= " WHERE teacher_username LIKE '$searchTeacher%'";
}
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Course</th><th>Teacher</th><th>Start Time</th><th>End Time</th><th>Date</th><th>Created At</th><th>Updated At</th><th>Class Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['class_id']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['teacher_username']}</td>";
            echo "<td>{$row['start_time']}</td>";
            echo "<td>{$row['end_time']}</td>";
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