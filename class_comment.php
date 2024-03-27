<?php
require_once 'includes/config.php';
date_default_timezone_set('Asia/Kolkata');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'], $_POST['class_id'], $_POST['comment'])) {
        $user_id = intval($_POST['user_id']); /
        $class_id = intval($_POST['class_id']); 
        $comment = htmlspecialchars($_POST['comment']);

        $stmt = $db->prepare("INSERT INTO class_comments (user_parent_id, class_parent_id, comment) VALUES (:user_id, :class_id, :comment)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':class_id', $class_id);
        $stmt->bindParam(':comment', $comment);

        if ($stmt->execute()) {
            $comment_id = $db->lastInsertId();

            $user_query = "SELECT user_name FROM users WHERE user_id = :user_id";
            $user_stmt = $db->prepare($user_query);
            $user_stmt->bindParam(':user_id', $user_id);
            $user_stmt->execute();
            $user = $user_stmt->fetch(PDO::FETCH_ASSOC);

            $output = '
                <p><strong>' . $user['user_name'] . '</strong> - ' . date('jS F Y, h:i A') . '</p>
                <p>' . $comment . '</p>
                <hr>
            ';

            echo $output;
        } else {
            echo "An error occurred while submitting the comment.";
        }
    } else {
        echo "Incomplete data. Please provide user_id, class_id, and comment.";
    }
} else {
    echo "Invalid request method. Please use POST.";
}
?>
