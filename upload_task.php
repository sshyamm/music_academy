<?php
require_once 'includes/config.php';
date_default_timezone_set('Asia/Kolkata');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remark'])) {
    $remark = $_POST['remark'];
    $task_parent_id = isset($_POST['task_id']) ? $_POST['task_id'] : null; 
    $user_parent_id = isset($_POST['user_id']) ? $_POST['user_id'] : null; 

    $file_path = null;
    if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['file_path']['name'];
        $file_tmp = $_FILES['file_path']['tmp_name'];

        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . date('YmdHis') . '.' . $file_ext;
        $upload_dir = "/opt/lampp/htdocs/music_academy/admin/getForms/uploads/";

        if (!move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            echo json_encode(array("success" => false, "message" => "Failed to move uploaded file."));
            exit();
        }

        $file_path = $new_file_name;
    }

    // Inserting current date and time into last_updated field
    $last_updated = date('Y-m-d H:i:s');

    $sql = "INSERT INTO tasks (task_parent_id, user_parent_id, remark, file_path, last_updated) VALUES (:task_parent_id, :user_parent_id, :remark, :file_path, :last_updated)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':task_parent_id', $task_parent_id);
    $stmt->bindParam(':user_parent_id', $user_parent_id);
    $stmt->bindParam(':remark', $remark);
    $stmt->bindParam(':file_path', $file_path);
    $stmt->bindParam(':last_updated', $last_updated);

    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "Task inserted successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Error occurred."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request"));
}
?>
