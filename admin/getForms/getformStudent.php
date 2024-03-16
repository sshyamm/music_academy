<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionStudent = isset($_POST['actionStudent']) ? $_POST['actionStudent'] : '';

    switch ($actionStudent) {
        case 'create_mode_student':
            $student_username = $_POST['student_username'];
            $student_password = $_POST['student_password'];
            $phone_num = $_POST['phone_num'];
            $email = $_POST['email'];
            $age_group_parent_id = $_POST['age_group_parent_id'];
            $course_parent_id = $_POST['course_parent_id'];
            $level_parent_id = $_POST['level_parent_id'];
            $emergency_contact = $_POST['emergency_contact'];
            $blood_group = $_POST['blood_group'];
            $address = $_POST['address'];
            $pincode = $_POST['pincode'];
            $city_parent_id = $_POST['city_parent_id'];
            $state_parent_id = $_POST['state_parent_id'];
            $country_parent_id = $_POST['country_parent_id'];
            $student_status = $_POST['student_status'];
            $joined_date = 'CURDATE()'; // Using MySQL CURDATE() function

            $sql = "INSERT INTO students (student_username, student_password, phone_num, email, age_group_parent_id, course_parent_id, level_parent_id, emergency_contact, blood_group, address, pincode, city_parent_id, state_parent_id, country_parent_id, student_status, joined_date)
                    VALUES ('$student_username', '$student_password', '$phone_num', '$email', '$age_group_parent_id', '$course_parent_id', '$level_parent_id', '$emergency_contact', '$blood_group', '$address', '$pincode', '$city_parent_id', '$state_parent_id', '$country_parent_id', '$student_status', $joined_date)";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Student created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_student':
            $student_id = $_POST['student_id']; 
            $student_username = $_POST['student_username'];
            $student_password = $_POST['student_password'];
            $phone_num = $_POST['phone_num'];
            $email = $_POST['email'];
            $age_group_parent_id = $_POST['age_group_parent_id'];
            $course_parent_id = $_POST['course_parent_id'];
            $level_parent_id = $_POST['level_parent_id'];
            $emergency_contact = $_POST['emergency_contact'];
            $blood_group = $_POST['blood_group'];
            $address = $_POST['address'];
            $pincode = $_POST['pincode'];
            $city_parent_id = $_POST['city_parent_id'];
            $state_parent_id = $_POST['state_parent_id'];
            $country_parent_id = $_POST['country_parent_id'];
            $student_status = $_POST['student_status'];

            $sql = "UPDATE students SET student_username='$student_username', student_password='$student_password', phone_num='$phone_num', email='$email', age_group_parent_id='$age_group_parent_id', course_parent_id='$course_parent_id', level_parent_id='$level_parent_id', emergency_contact='$emergency_contact', blood_group='$blood_group', address='$address', pincode='$pincode', city_parent_id='$city_parent_id', state_parent_id='$state_parent_id', country_parent_id='$country_parent_id', student_status='$student_status' WHERE student_id=$student_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Student updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_student':
            $student_id = $_POST['student_id'];
            $sql = "DELETE FROM students WHERE student_id=$student_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Student deleted successfully!!');
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
