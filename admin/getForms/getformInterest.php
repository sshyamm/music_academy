<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionInt = isset($_POST['actionInt']) ? $_POST['actionInt'] : '';

    switch ($actionInt) {
        case 'create_mode_int':
            $user_parent_id = $_POST['user_parent_id'];
            $course_parent_id = $_POST['course_parent_id'];
            $level_parent_id = $_POST['level_parent_id'];
            $interest_status = $_POST['interest_status'];
            

            $sql = "INSERT INTO interests (user_parent_id, course_parent_id, level_parent_id, interest_status)
                    VALUES ('$user_parent_id', '$course_parent_id', '$level_parent_id','$interest_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Interest created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_int':
            $interest_id = $_POST['interest_id'];
            $user_parent_id = $_POST['user_parent_id'];
            $course_parent_id = $_POST['course_parent_id'];
            $level_parent_id = $_POST['level_parent_id'];
            $interest_status = $_POST['interest_status'];

            $sql = "UPDATE interests SET user_parent_id='$user_parent_id', course_parent_id='$course_parent_id', level_parent_id='$level_parent_id', interest_status='$interest_status' WHERE interest_id=$interest_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Interest updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_int':
            $interest_id = $_POST['interest_id'];
            $sql = "DELETE FROM interests WHERE interest_id=$interest_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Interest deleted successfully!!');
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
