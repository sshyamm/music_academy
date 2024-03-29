<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionNews = isset($_POST['actionNews']) ? $_POST['actionNews'] : '';

    switch ($actionNews) {
        case 'create_mode_news':
            $email = $_POST['email'];
            $news_status = $_POST['news_status'];
            

            $sql = "INSERT INTO news (email, news_status)
                    VALUES ('$email', '$news_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'News created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_news':
            $news_id = $_POST['news_id'];
            $email = $_POST['email'];
            $news_status = $_POST['news_status'];

            $sql = "UPDATE news SET email='$email', news_status='$news_status' WHERE news_id=$news_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'News updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_news':
            $news_id = $_POST['news_id'];
            $sql = "DELETE FROM news WHERE news_id=$news_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'News deleted successfully!!');
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
