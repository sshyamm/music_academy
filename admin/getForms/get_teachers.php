<?php
require_once("../db.php");
echo "<option value=''>Select Teacher</option>";
if(isset($_POST['course_parent_id'])) {
    $course_parent_id = $_POST['course_parent_id'];
    
    $teacher_sql = "SELECT * FROM teachers WHERE course_parent_id = $course_parent_id";
    $teacher_result = $conn->query($teacher_sql);

    if ($teacher_result->num_rows > 0) {
        while ($teacher_row = $teacher_result->fetch_assoc()) {
            echo "<option value='" . $teacher_row['teacher_id'] . "'>" . $teacher_row['teacher_username'] . "</option>";
        }
    } else {
        echo "<option value=''>No teachers available</option>";
    }
}
?>
