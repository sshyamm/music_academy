<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_manager_id'])) {
    $task_manager_id = $_POST['task_manager_id'];

    $delete_sql = "DELETE FROM tasks WHERE task_manager_id = :task_manager_id";
    $delete_stmt = $db->prepare($delete_sql);
    $delete_stmt->bindParam(':task_manager_id', $task_manager_id);
    if ($delete_stmt->execute()) {
        $rows_affected = $delete_stmt->rowCount();
        if ($rows_affected > 0) {
            $response = array('success' => true, 'message' => 'Submission deleted successfully.');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Submission not found or already deleted.');
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'Error deleting submission.');
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request.');
    echo json_encode($response);
}
?>
