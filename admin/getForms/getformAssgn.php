<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionAssgn = isset($_POST['actionAssgn']) ? $_POST['actionAssgn'] : '';

    $response = array();

    switch ($actionAssgn) {
        case 'create_mode_assgn':
            $task_desc = isset($_POST['task_desc']) ? trim($_POST['task_desc']) : '';
            $course_parent_id = isset($_POST['course_parent_id']) ? trim($_POST['course_parent_id']) : '';
            $date_parent_id = isset($_POST['date_parent_id']) ? trim($_POST['date_parent_id']) : '';
            $task_file = '';
            $task_status = isset($_POST['task_status']) ? trim($_POST['task_status']) : '';
            
            if (!empty($_FILES['task_file']['name'])) {
                $file_name = $_FILES['task_file']['name'];
                $file_tmp = $_FILES['task_file']['tmp_name'];
                $uploadDir = '/opt/lampp/htdocs/music_academy/admin/getForms/uploads/'; 
                $task_file = $file_name;

                if (move_uploaded_file($file_tmp, $task_file)) {
                } else {
                    $response = array('success' => false, 'message' => 'Error moving uploaded file.');
                    echo json_encode($response);
                    exit; 
                }
            }

            $sql = "INSERT INTO class_tasks (task_desc, course_parent_id, date_parent_id, task_file, task_status)
                    VALUES ('$task_desc', '$course_parent_id', '$date_parent_id', '$task_file','$task_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Task created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_assgn':
            $task_id = isset($_POST['task_id']) ? trim($_POST['task_id']) : '';
            $task_desc = isset($_POST['task_desc']) ? trim($_POST['task_desc']) : '';
            $course_parent_id = isset($_POST['course_parent_id']) ? trim($_POST['course_parent_id']) : '';
            $date_parent_id = isset($_POST['date_parent_id']) ? trim($_POST['date_parent_id']) : '';
            $task_file = '';
            $task_status = isset($_POST['task_status']) ? trim($_POST['task_status']) : '';

            if (!empty($_FILES['task_file']['name'])) {
                $file_name = $_FILES['task_file']['name'];
                $file_tmp = $_FILES['task_file']['tmp_name'];
                $uploadDir = '/opt/lampp/htdocs/music_academy/admin/getForms/uploads/'; 
                $task_file = $file_name;

                if (move_uploaded_file($file_tmp, $task_file)) {
                } else {
                    $response = array('success' => false, 'message' => 'Error moving uploaded file.');
                    echo json_encode($response);
                    exit; 
                }
            }

            $sql = "UPDATE class_tasks SET task_desc='$task_desc', course_parent_id='$course_parent_id', date_parent_id='$date_parent_id', task_file='$task_file', task_status='$task_status' WHERE task_id=$task_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Task updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_assgn':
            $task_id = isset($_POST['task_id']) ? trim($_POST['task_id']) : '';
            $sql = "DELETE FROM class_tasks WHERE task_id=$task_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Task deleted successfully!!');
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
