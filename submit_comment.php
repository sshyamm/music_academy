<?php
require_once 'includes/config.php';

date_default_timezone_set('Asia/Kolkata');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST['comment'];
    $user_id = $_POST['user_id']; 
    $course_id = $_POST['course_id']; 

    $query = "INSERT INTO comments (user_parent_id, comment, course_parent_id, created_at, comment_status)
              VALUES (:user_id, :comment, :course_id, NOW(), 'Active')";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':comment', $comment);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->execute();

    $user_query = "SELECT user_name FROM users WHERE user_id = :user_id";
    $user_stmt = $db->prepare($user_query);
    $user_stmt->bindParam(':user_id', $user_id);
    $user_stmt->execute();
    $user = $user_stmt->fetch(PDO::FETCH_ASSOC);

    $new_comment_html = '<div class="comment">';
    $new_comment_html .= '<div class="meta">' . $user['user_name'] . ' - ' . date('jS F Y, h:i A') . '</div>'; 
    $new_comment_html .= '<div class="user-content">' . htmlspecialchars($comment) . '</div>'; 
    $new_comment_html .= '</div>';

    echo $new_comment_html;
} else {
    echo "Error: Form submission method not allowed.";
}
?>
