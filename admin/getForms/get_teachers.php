<?php
include("../db.php");
if(isset($_POST['course_parent_id']) && !empty($_POST['course_parent_id'])) {
    $course_parent_id = $_POST['course_parent_id'];

    echo "<option value=''>Select Teacher</option>";

    $teacher_sql = "SELECT u.user_id, u.user_name 
                    FROM users u
                    INNER JOIN teachers t ON u.user_id = t.user_parent_id
                    WHERE t.course_parent_id = $course_parent_id";
    $teacher_result = $conn->query($teacher_sql);

    if ($teacher_result->num_rows > 0) {
        while ($teacher_row = $teacher_result->fetch_assoc()) {
            echo "<option value='" . $teacher_row['user_id'] . "'>" . $teacher_row['user_name'] . "</option>";
        }
    } else {
        echo "<option value='' selected>No teachers available</option>";
    }
} else {
    echo "<option value='' selected>Select Course first</option>";
}
?>
