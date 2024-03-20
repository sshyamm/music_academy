<?php
require_once("../db.php");
echo "<option value=''>Select Class</option>";
if(isset($_POST['course_parent_id'])) {
    $course_parent_id = $_POST['course_parent_id'];
    $class_sql = "SELECT c.class_id, c.date_of_class, crs.course_name 
                    FROM classes c
                    INNER JOIN courses crs ON c.course_parent_id = crs.course_id
                    WHERE c.course_parent_id = $course_parent_id"; 
    $class_result = $conn->query($class_sql);
    if ($class_result->num_rows > 0) {
        while ($class_row = $class_result->fetch_assoc()) {
            $display_text = $class_row['date_of_class'] . ' (' . $class_row['course_name'] . ')';
            $option_value = $class_row['class_id'];
            $encoded_display_text = htmlspecialchars($display_text);
            echo "<option value='$option_value'>$encoded_display_text</option>";
        }
    } else { 
        echo "<option value='' selected>No classes available</option>";
    }
}
?>