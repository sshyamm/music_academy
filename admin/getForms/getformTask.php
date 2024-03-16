<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actionTask = isset($_POST['actionTask']) ? $_POST['actionTask'] : '';

    $response = array();

    switch ($actionTask) {
        case 'create_mode_task':
            $task_title = trim($_POST['task_title']);
            $task_desc = trim($_POST['task_desc']);
            $assigned_to = trim($_POST['assigned_to']);
            $assigned_by = trim($_POST['assigned_by']);
            $deadline = trim($_POST['deadline']);
            $priority = trim($_POST['priority']);
            $estimated_hours = trim($_POST['estimated_hours']);
            $task_status = trim($_POST['task_status']);
            $file_path = '';

            if ($task_status === 'Completed' && !empty($_FILES['file_path']['name'])) {
                $file_name = $_FILES['file_path']['name'];
                $file_tmp = $_FILES['file_path']['tmp_name'];
                $uploadDir = 'uploads/'; 
                $file_path = $uploadDir . $file_name;

                if (move_uploaded_file($file_tmp, $file_path)) {
                } else {
                    $response = array('success' => false, 'message' => 'Error moving uploaded file.');
                    echo json_encode($response);
                    exit; 
                }
            }

            $currentDateTime = date('Y-m-d H:i:s');
            $created_at = $currentDateTime;
            $updated_at = $created_at;

            $sql = "INSERT INTO tasks (task_title, task_desc, assigned_to, assigned_by, deadline, priority, created_at, updated_at, estimated_hours, file_path, task_status)
                    VALUES ('$task_title', '$task_desc', '$assigned_to', '$assigned_by', '$deadline', '$priority', '$created_at', '$updated_at', '$estimated_hours', '$file_path', '$task_status')";
            
            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Task created successfully.');
            } else {
                $response = array('success' => false, 'message' => 'Error creating task: ' . $conn->error);
            }
            break;

        case 'edit_mode_task':
            $task_id = trim($_POST['task_id']);
            $task_title = trim($_POST['task_title']);
            $task_desc = trim($_POST['task_desc']);
            $assigned_to = trim($_POST['assigned_to']);
            $assigned_by = trim($_POST['assigned_by']);
            $deadline = trim($_POST['deadline']);
            $priority = trim($_POST['priority']);
            $estimated_hours = trim($_POST['estimated_hours']);
            $task_status = trim($_POST['task_status']);
            $file_path = '';

            if ($task_status === 'Completed' && !empty($_FILES['file_path']['name'])) {
                $file_name = $_FILES['file_path']['name'];
                $file_tmp = $_FILES['file_path']['tmp_name'];
                $uploadDir = 'uploads/';
                $file_path = $uploadDir . $file_name;

                if (move_uploaded_file($file_tmp, $file_path)) {
                } else {
                    $response = array('success' => false, 'message' => 'Error moving uploaded file.');
                    echo json_encode($response);
                    exit; 
                }
            }

            $updated_at = date('Y-m-d H:i:s');

            $sql = "UPDATE tasks SET task_title='$task_title', task_desc='$task_desc', assigned_to='$assigned_to', assigned_by='$assigned_by', deadline='$deadline', priority='$priority', updated_at='$updated_at', estimated_hours='$estimated_hours', file_path='$file_path', task_status='$task_status' WHERE task_id=$task_id";
            
            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Task updated successfully.');
            } else {
                $response = array('success' => false, 'message' => 'Error updating task: ' . $conn->error);
            }
            break;

        case 'delete_mode_task':
            $task_id = trim($_POST['task_id']);

            $sql = "DELETE FROM tasks WHERE task_id=$task_id";

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
