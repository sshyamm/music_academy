<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['class_room_id']) && isset($_POST['attendance'])) {
        
        require_once 'includes/config.php';

        $class_room_id = $_POST['class_room_id'];
        $attendance = $_POST['attendance'];

        $sql = "UPDATE class_rooms SET attendance = :attendance WHERE class_room_id = :class_room_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':attendance', $attendance);
        $stmt->bindParam(':class_room_id', $class_room_id);

        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Attendance updated successfully."));
            exit();
        } else {
            echo json_encode(array("success" => false, "message" => "Failed to update attendance."));
            exit();
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Missing required parameters."));
        exit();
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method."));
    exit();
}
?>