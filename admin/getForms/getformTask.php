<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actionTask = isset($_POST['actionTask']) ? $_POST['actionTask'] : '';

    $response = array();

    switch ($actionTask) {
        case 'create_mode_task':
            $task_parent_id = trim($_POST['task_parent_id']);
            $user_parent_id = trim($_POST['user_parent_id']);
            $remark = trim($_POST['remark']);
            $comment = trim($_POST['comment']);
            $grading = trim($_POST['grading']);
            $last_updated = date('Y-m-d H:i:s');
            $submit_status = trim($_POST['submit_status']);
            $file_path = '';

            if (!empty($_FILES['file_path']['name'])) {
                $file_name = $_FILES['file_path']['name'];
                $file_tmp = $_FILES['file_path']['tmp_name'];
                $uploadDir = 'uploads/'; 
                $file_path = $file_name;

                if (move_uploaded_file($file_tmp, $uploadDir . $file_path)) {
                } else {
                    $response = array('success' => false, 'message' => 'Error moving uploaded file.');
                    echo json_encode($response);
                    exit; 
                }
            }

            $sql = "INSERT INTO tasks (task_parent_id, user_parent_id, remark, comment, grading, file_path, last_updated, submit_status)
                    VALUES ('$task_parent_id', '$user_parent_id', '$remark', '$comment', '$grading', '$file_path', '$last_updated', '$submit_status')";
            
            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Task created successfully.');
            } else {
                $response = array('success' => false, 'message' => 'Error creating task: ' . $conn->error);
            }
            break;

        case 'edit_mode_task':
            $task_manager_id = trim($_POST['task_manager_id']);
            $task_parent_id = trim($_POST['task_parent_id']);
            $user_parent_id = trim($_POST['user_parent_id']);
            $remark = trim($_POST['remark']);
            $comment = trim($_POST['comment']);
            $grading = trim($_POST['grading']);
            $last_updated = date('Y-m-d H:i:s');
            $submit_status = trim($_POST['submit_status']);
            $file_path = '';

            if (!empty($_FILES['file_path']['name'])) {
                $file_name = $_FILES['file_path']['name'];
                $file_tmp = $_FILES['file_path']['tmp_name'];
                $uploadDir = 'uploads/'; 
                $file_path = $file_name;

                if (move_uploaded_file($file_tmp, $uploadDir . $file_path)) {
                } else {
                    $response = array('success' => false, 'message' => 'Error moving uploaded file.');
                    echo json_encode($response);
                    exit; 
                }
            }

            $sql = "UPDATE tasks SET task_parent_id='$task_parent_id', user_parent_id='$user_parent_id', remark='$remark', comment='$comment', grading='$grading', file_path='$file_path', last_updated='$last_updated', submit_status='$submit_status' WHERE task_manager_id=$task_manager_id";
            
            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Task updated successfully.');
            } else {
                $response = array('success' => false, 'message' => 'Error updating task: ' . $conn->error);
            }
            break;

        case 'delete_mode_task':
            $task_manager_id = trim($_POST['task_manager_id']);

            $sql = "DELETE FROM tasks WHERE task_manager_id=$task_manager_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Task deleted successfully.');
            } else {
                $response = array('success' => false, 'message' => 'Error deleting task: ' . $conn->error);
            }
            break;

        default:
            $response = array('success' => false, 'message' => 'Invalid actionTask.');
            break;
    }

    $conn->close();
} else {
    $response = array('success' => false, 'message' => 'Invalid request method.');
}

echo json_encode($response);
?>
