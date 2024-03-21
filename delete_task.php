<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];

    require_once 'includes/config.php';

    $sql = "DELETE FROM class_tasks WHERE task_id = :task_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':task_id', $task_id, PDO::PARAM_INT);
    
    if($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete task']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Class task ID is not provided']);
}
?>