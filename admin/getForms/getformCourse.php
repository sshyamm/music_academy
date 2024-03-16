<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionCourse = isset($_POST['actionCourse']) ? $_POST['actionCourse'] : '';

    switch ($actionCourse) {
        case 'create_mode_course':
            $course_name = $_POST['course_name'];
            $course_desc = $_POST['course_desc'];
            $course_img = isset($_FILES['course_img']['name']) ? $_FILES['course_img']['name'] : '';
            $course_icon = isset($_FILES['course_icon']['name']) ? $_FILES['course_icon']['name'] : '';
            $course_status = $_POST['course_status'];

            $uploadDir = 'uploads/'; 
            move_uploaded_file($_FILES['course_img']['tmp_name'], $uploadDir . $course_img);
            move_uploaded_file($_FILES['course_icon']['tmp_name'], $uploadDir . $course_icon);

            $sql = "INSERT INTO courses (course_name, course_desc, course_img, course_icon, course_status)
                    VALUES ('$course_name', '$course_desc', '$course_img', '$course_icon', '$course_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Course created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_course':
            $course_id = $_POST['course_id'];
            $course_name = $_POST['course_name'];
            $course_desc = $_POST['course_desc'];
            $course_img = isset($_FILES['course_img']['name']) ? $_FILES['course_img']['name'] : '';
            $course_icon = isset($_FILES['course_icon']['name']) ? $_FILES['course_icon']['name'] : '';
            $course_status = $_POST['course_status'];

            $uploadDir = 'uploads/'; 
            move_uploaded_file($_FILES['course_img']['tmp_name'], $uploadDir . $course_img);
            move_uploaded_file($_FILES['course_icon']['tmp_name'], $uploadDir . $course_icon);

            $sql = "UPDATE courses SET course_name='$course_name', course_desc='$course_desc', course_img='$course_img', course_icon='$course_icon', course_status='$course_status' WHERE course_id=$course_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Course updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_course':
            $course_id = $_POST['course_id'];
            $sql = "DELETE FROM courses WHERE course_id=$course_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Course deleted successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;
        case 'list_mode_course':
            $sql = "SELECT * FROM courses";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $courses = array();
                while ($row = $result->fetch_assoc()) {
                    $courses[] = $row;
                }
                $response = array('success' => true, 'data' => $courses);
            } else {
                $response = array('success' => false, 'message' => 'No courses found');
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
