<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_manager_id = isset($_POST['task_manager_id']) ? $_POST['task_manager_id'] : null;
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    $grading = isset($_POST['grading']) ? $_POST['grading'] : '';

    $stmt = $db->prepare("UPDATE tasks SET comment = ?, grading = ?, submit_status = CASE WHEN ? <> '' THEN 'Graded & Completed' ELSE submit_status END WHERE task_manager_id = ?");
    $stmt->execute([$comment, $grading, $grading, $task_manager_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(array("success" => true, "message" => "Evaluation updated successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Failed to update evaluation."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request."));
}
?>
