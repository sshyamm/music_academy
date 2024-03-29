<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionImg = isset($_POST['actionImg']) ? $_POST['actionImg'] : '';

    switch ($actionImg) {
        case 'create_mode_img':
            $image_name = $_POST['image_name'];
            $image_path = isset($_FILES['image_path']['name']) ? $_FILES['image_path']['name'] : '';
            $image_status = $_POST['image_status'];

            $uploadDir = '/opt/lampp/htdocs/music_academy/admin/getForms/img/';

            $currentDateTime = date('Y-m-d_H-i-s');
            $image_path_with_datetime = pathinfo($image_path, PATHINFO_FILENAME) . '_' . $currentDateTime . '.' . pathinfo($image_path, PATHINFO_EXTENSION);

            move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadDir . $image_path_with_datetime);

            $sql = "INSERT INTO images (image_name, image_path, image_status)
                    VALUES ('$image_name', '$image_path_with_datetime', '$image_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Image created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_img':
            $image_id = $_POST['image_id'];
            $image_name = $_POST['image_name'];
            $image_path = isset($_FILES['image_path']['name']) ? $_FILES['image_path']['name'] : '';
            $image_status = $_POST['image_status'];

            $uploadDir = '/opt/lampp/htdocs/music_academy/admin/getForms/img/';

            $currentDateTime = date('Y-m-d_H-i-s');
            $image_path_with_datetime = pathinfo($image_path, PATHINFO_FILENAME) . '_' . $currentDateTime . '.' . pathinfo($image_path, PATHINFO_EXTENSION);

            move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadDir . $image_path_with_datetime);

            $sql = "UPDATE images SET image_name='$image_name', image_path='$image_path_with_datetime', image_status='$image_status' WHERE image_id=$image_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Image updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_img':
            $image_id = $_POST['image_id'];
            $sql = "DELETE FROM images WHERE image_id=$image_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Image deleted successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;
    }

    $conn->close();

    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>
