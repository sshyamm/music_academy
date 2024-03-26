<?php
require_once 'includes/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_manager_id'])) {
    $task_manager_id = $_POST['task_manager_id'];
    $remark = $_POST['remark'];
    
    $file_path = ''; 
    if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['file_path']['name'];
        $file_tmp = $_FILES['file_path']['tmp_name'];

        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . date('YmdHis') . '.' . $file_ext;
        $upload_dir = "/opt/lampp/htdocs/music_academy/admin/getForms/uploads/";

        if (!move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            $response = array("success" => false, "message" => "Failed to move uploaded file.");
            echo json_encode($response);
            exit();
        }

        $file_path = $new_file_name;
    }

    $update_sql = "UPDATE tasks SET remark = :remark, last_updated = NOW()";
    if (!empty($file_path)) {
        $update_sql .= ", file_path = :file_path";
    }
    $update_sql .= " WHERE task_manager_id = :task_manager_id";
    $update_stmt = $db->prepare($update_sql);
    $update_stmt->bindParam(':task_manager_id', $task_manager_id);
    $update_stmt->bindParam(':remark', $remark);
    if (!empty($file_path)) {
        $update_stmt->bindParam(':file_path', $file_path);
    }
    if ($update_stmt->execute()) {
        $response = array("success" => true, "message" => "Submission updated successfully.");
        echo json_encode($response);
    } else {
        $response = array("success" => false, "message" => "Failed to update submission.");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "message" => "Invalid request.");
    echo json_encode($response);
}
?>
