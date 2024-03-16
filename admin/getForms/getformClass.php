<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionClass = isset($_POST['actionClass']) ? $_POST['actionClass'] : '';

    switch ($actionClass) {
        case 'create_mode_class':
            $course_parent_id = $_POST['course_parent_id'];
            $teacher_parent_id = $_POST['teacher_parent_id'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $date_of_class = $_POST['date_of_class'];
            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;
            $class_status = $_POST['class_status'];

            $sql = "INSERT INTO classes (course_parent_id, teacher_parent_id, start_time, end_time, date_of_class, created_at, updated_at, class_status)
                    VALUES ('$course_parent_id', '$teacher_parent_id', '$start_time', '$end_time', '$date_of_class', '$created_at', '$updated_at', '$class_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Class created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_class':
            $class_id = $_POST['class_id'];
            $course_parent_id = $_POST['course_parent_id'];
            $teacher_parent_id = $_POST['teacher_parent_id'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $date_of_class = $_POST['date_of_class'];
            $updated_at = date('Y-m-d H:i:s'); 
            $class_status = $_POST['class_status'];

            $sql = "UPDATE classes SET course_parent_id='$course_parent_id', teacher_parent_id='$teacher_parent_id', start_time='$start_time', end_time='$end_time', date_of_class='$date_of_class', updated_at='$updated_at', class_status='$class_status' WHERE class_id=$class_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Class updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_class':
            $class_id = $_POST['class_id'];
            $sql = "DELETE FROM classes WHERE class_id=$class_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Class deleted successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        default:
            $response = array('success' => false, 'message' => 'Invalid action');
            break;
    }

    $conn->close();

    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>
