<?php
include("../db.php");

$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Course Name</th><th>Course Description</th><th>Course Image</th><th>Course Icon</th><th>Course Status</th><th>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['course_id']}</td>";
        echo "<td>{$row['course_name']}</td>";
        echo "<td>{$row['course_desc']}</td>";
        echo "<td><img src='getForms/uploads/{$row['course_img']}' alt='Course Image'></td>";
        echo "<td><img src='getForms/uploads/{$row['course_icon']}' alt='Course Icon'></td>";
        echo "<td>{$row['course_status']}</td>";
        echo "<td>";
        echo "<button onclick=\"showFormCourse('edit_mode_course', {$row['course_id']})\">Edit</button>";
        echo "<button onclick=\"showFormCourse('delete_mode_course', {$row['course_id']})\">Delete</button>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No courses found.";
}

$conn->close();
?>
