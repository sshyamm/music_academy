<?php
if (isset($_POST['action'])) {
    require_once 'includes/config.php';

    $action = $_POST['action'];
    $classId = $_POST['class_id'];

    $status = '';

    if ($action === "start") {
        $sql = "UPDATE classes SET actual_start_time = NOW(), class_status = 'Ongoing' WHERE class_id = :class_id";
        $status = 'Ongoing';
    } elseif ($action === "end") {
        $sql = "UPDATE classes SET actual_end_time = NOW(), class_status = 'Finished' WHERE class_id = :class_id";
        $status = 'Finished';
    }

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':class_id', $classId);
    $stmt->execute();

    // Send the updated class status back to the client
    echo json_encode(array("status" => "success", "message" => "Class status updated successfully.", "class_status" => $status));
} else {
    echo json_encode(array("status" => "error", "message" => "Action parameter is not set."));
}
?>
