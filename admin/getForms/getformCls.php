<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionCls = isset($_POST['actionCls']) ? $_POST['actionCls'] : '';

    switch ($actionCls) {
        case 'create_mode_cls':
            $user_parent_id = $_POST['user_parent_id'];
            $class_parent_id = $_POST['class_parent_id'];
            $comment = $_POST['comment'];
            $comment_status = $_POST['comment_status'];

            $sql = "INSERT INTO class_comments (user_parent_id, class_parent_id, comment, comment_status)
                    VALUES ('$user_parent_id', '$class_parent_id', '$comment', '$comment_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Comment created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_cls':
            $comment_id = $_POST['comment_id'];
            $user_parent_id = $_POST['user_parent_id'];
            $class_parent_id = $_POST['class_parent_id'];
            $comment = $_POST['comment'];
            $comment_status = $_POST['comment_status'];

            $sql = "UPDATE class_comments SET user_parent_id='$user_parent_id', class_parent_id='$class_parent_id', comment='$comment', comment_status='$comment_status' WHERE comment_id=$comment_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Comment updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_cls':
            $comment_id = $_POST['comment_id'];
            $sql = "DELETE FROM class_comments WHERE comment_id=$comment_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Comment deleted successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        default:
            $response = array('success' => false, 'message' => 'Invalid action');
            break;
    }

    $conn->close();

    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>
