<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../db.php";

    $actionTeacher = isset($_POST['actionTeacher']) ? $_POST['actionTeacher'] : '';

    switch ($actionTeacher) {
        case 'create_mode_teacher':
            $user_parent_id = $_POST['user_parent_id'];
            $teacher_phone = $_POST['teacher_phone'];
            $teacher_email = $_POST['teacher_email'];
            $teacher_address = $_POST['teacher_address'];
            $course_parent_id = $_POST['course_parent_id'];
            $qualification = $_POST['qualification'];
            $teacher_exp = $_POST['teacher_exp'];
            $contract_date = $_POST['contract_date'];
            $current_salary = $_POST['current_salary'];
            $join_date = $_POST['join_date'];
            $teacher_status = $_POST['teacher_status'];

            $sql = "INSERT INTO teachers (user_parent_id, teacher_phone, teacher_email, teacher_address, course_parent_id, qualification, teacher_exp, contract_date, current_salary, join_date, teacher_status)
                    VALUES ('$user_parent_id', '$teacher_phone', '$teacher_email', '$teacher_address', '$course_parent_id', '$qualification', $teacher_exp, '$contract_date', $current_salary, '$join_date', '$teacher_status')";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Teacher created successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'edit_mode_teacher':
            $teacher_id = $_POST['teacher_id'];
            $user_parent_id = $_POST['user_parent_id'];  
            $teacher_phone = $_POST['teacher_phone'];
            $teacher_email = $_POST['teacher_email'];
            $teacher_address = $_POST['teacher_address'];
            $course_parent_id = $_POST['course_parent_id'];
            $qualification = $_POST['qualification'];
            $teacher_exp = $_POST['teacher_exp'];
            $contract_date = $_POST['contract_date'];
            $current_salary = $_POST['current_salary'];
            $join_date = $_POST['join_date'];
            $teacher_status = $_POST['teacher_status'];

            $sql = "UPDATE teachers SET user_parent_id='$user_parent_id', teacher_phone='$teacher_phone', teacher_email='$teacher_email', teacher_address='$teacher_address', course_parent_id='$course_parent_id', qualification='$qualification', teacher_exp=$teacher_exp, contract_date='$contract_date', current_salary=$current_salary, join_date='$join_date', teacher_status='$teacher_status' WHERE teacher_id=$teacher_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Teacher updated successfully!!');
            } else {
                $response = array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error);
            }
            break;

        case 'delete_mode_teacher':
            $teacher_id = $_POST['teacher_id'];
            $sql = "DELETE FROM teachers WHERE teacher_id=$teacher_id";

            if ($conn->query($sql) === TRUE) {
                $response = array('success' => true, 'message' => 'Teacher deleted successfully!!');
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
