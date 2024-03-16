<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionPhase = isset($_POST['actionPhase']) ? $_POST['actionPhase'] : '';

    switch ($actionPhase) {
        case 'create_mode_phase':
            $class_parent_id = $_POST['class_parent_id'];
            $student_parent_id = $_POST['student_parent_id'];
            $attendance = $_POST['attendance'];
            $attendance_time = ($attendance === "Present" || $attendance === "Late") ? date("Y-m-d H:i:s") : "Absent";
            $class_room_status = $_POST['class_room_status'];

            $sql = "INSERT INTO class_rooms (class_parent_id, student_parent_id, attendance, attendance_time, class_room_status)
                    VALUES ('$class_parent_id', '$student_parent_id', '$attendance', '$attendance_time', '$class_room_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Room created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_phase':
            $class_room_id = $_POST['class_room_id'];
            $class_parent_id = $_POST['class_parent_id'];
            $student_parent_id = $_POST['student_parent_id'];
            $attendance = $_POST['attendance'];
            $attendance_time = ($attendance === "Present" || $attendance === "Late") ? date("Y-m-d H:i:s") : "Absent";
            $class_room_status = $_POST['class_room_status'];

            $sql = "UPDATE class_rooms SET class_parent_id='$class_parent_id', student_parent_id='$student_parent_id', attendance='$attendance', attendance_time='$attendance_time', class_room_status='$class_room_status' WHERE class_room_id=$class_room_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Room updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_phase':
            $class_room_id = $_POST['class_room_id'];
            $sql = "DELETE FROM class_rooms WHERE class_room_id=$class_room_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Room deleted successfully!!');
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
