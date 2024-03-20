<?php
if(isset($_POST['class_room_id'])) {
    $class_room_id = $_POST['class_room_id'];

    require_once 'includes/config.php';

    $sql = "DELETE FROM class_rooms WHERE class_room_id = :class_room_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':class_room_id', $class_room_id, PDO::PARAM_INT);
    
    if($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Student deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete student']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Class room ID is not provided']);
}
?>
