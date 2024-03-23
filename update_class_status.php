<?php
if (isset($_POST['action'])) {
    require_once 'includes/config.php';

    $action = $_POST['action'];
    $classId = $_POST['class_id'];

    if ($action === "start") {
        $sql = "UPDATE classes SET actual_start_time = NOW() WHERE class_id = :class_id";
    } elseif ($action === "end") {
        $sql = "UPDATE classes SET actual_end_time = NOW() WHERE class_id = :class_id";
    }

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':class_id', $classId);
    $stmt->execute();

    echo json_encode(array("status" => "success", "message" => "Class status updated successfully."));
} else {
    echo json_encode(array("status" => "error", "message" => "Action parameter is not set."));
}
?>
