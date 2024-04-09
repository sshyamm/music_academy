<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_desc'])) {
    $task_desc = $_POST['task_desc'];
    $task_deadline = $_POST['task_deadline']; 
    $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : null;
    $edit_task_id = isset($_POST['edit_task_id']) ? $_POST['edit_task_id'] : null;

    if (isset($_FILES['task_file']) && $_FILES['task_file']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['task_file']['name'];
        $file_tmp = $_FILES['task_file']['tmp_name'];

        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = pathinfo($file_name, PATHINFO_FILENAME) . '_' . date('YmdHis') . '.' . $file_ext;
        $upload_dir = "/var/www/html/music_academy/admin/getForms/uploads/";

        if (!move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            echo json_encode(array("success" => false, "message" => "Failed to move uploaded file."));
            exit();
        }
    } else {
        $new_file_name = null;
    }

    if (!empty($edit_task_id)) {
        $sql = "UPDATE class_tasks SET task_desc = :task_desc, task_deadline = :task_deadline";
        if (!is_null($new_file_name)) {
            $sql .= ", task_file = :task_file";
        }
        $sql .= " WHERE task_id = :task_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':task_desc', $task_desc);
        $stmt->bindParam(':task_deadline', $task_deadline); 
        if (!is_null($new_file_name)) {
            $stmt->bindParam(':task_file', $new_file_name);
        }
        $stmt->bindParam(':task_id', $edit_task_id);
    } else {
        $query = "SELECT course_parent_id FROM classes WHERE class_id = :class_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':class_id', $class_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo json_encode(array("success" => false, "message" => "Class not found."));
            exit();
        }

        $course_parent_id = $result['course_parent_id'];

        $sql = "INSERT INTO class_tasks (task_desc, task_file, date_parent_id, course_parent_id, task_deadline) VALUES (:task_desc, :task_file, :class_id, :course_parent_id, :task_deadline)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':task_desc', $task_desc);
        $stmt->bindParam(':task_file', $new_file_name);
        $stmt->bindParam(':class_id', $class_id);
        $stmt->bindParam(':course_parent_id', $course_parent_id);
        $stmt->bindParam(':task_deadline', $task_deadline);
    }

    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "Task " . (!empty($edit_task_id) ? "updated" : "created") . " successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Error occurred."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request"));
}
?>
