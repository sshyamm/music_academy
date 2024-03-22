<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['user_id']) && isset($_POST['course_id'])) {
        $user_id = $_POST['user_id'];
        $course_id = $_POST['course_id'];

        $sql = "SELECT COUNT(*) AS count FROM interests WHERE user_parent_id = :user_id AND course_parent_id = :course_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] == 0) {
            $insertSql = "INSERT INTO interests (user_parent_id, course_parent_id) VALUES (:user_id, :course_id)";
            $insertStmt = $db->prepare($insertSql);
            $insertStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $insertStmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
            if ($insertStmt->execute()) {
                echo 'success';
            } else {
                echo 'error';
            }
        } else {
            echo 'already_applied';
        }
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>