<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';

    if (isset($_POST['selected_students']) && !empty($_POST['selected_students'])) {
        $sql = "INSERT INTO class_rooms (user_parent_id, class_parent_id) VALUES (:user_id, :class_id)";
        $stmt = $db->prepare($sql);

        foreach ($_POST['selected_students'] as $user_id) {
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':class_id', $class_id);
            $stmt->execute();
        }

        echo "success";
    } else {
        echo "error";
    }
}
?>