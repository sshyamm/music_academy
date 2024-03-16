<!DOCTYPE html>
<html>
<head>
    <style>
        form {
            width: 50%;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }

        input[type="date"],
        input[type="time"],
        select {
            padding: 10px;
            margin: 10px;
            width: 90%;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }

        button[type="button"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #90EE90;
            color: black;
            border: none;
            cursor: pointer;
        }

        button[type="button"]:hover {
            background-color: #7CFC00;
        }
    </style>
</head>
<body>

<?php
$actionClass = isset($_GET['actionClass']) ? $_GET['actionClass'] : 'create_mode_class';
$course_parent_id = '';
$teacher_parent_id = '';
$start_time = '';
$end_time = '';
$date_of_class = '';
$class_status = '';

if ($actionClass == 'edit_mode_class') {
    include("../db.php");

    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
    if ($class_id !== null) {
        $my_sql  = "SELECT * FROM classes WHERE class_id = $class_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $course_parent_id = $row["course_parent_id"];
            $teacher_parent_id = $row["teacher_parent_id"];
	    $start_time = $row["start_time"];
	    $end_time = $row["end_time"];
            $date_of_class = $row["date_of_class"];
            $class_status = $row["class_status"];
        }
    }
}
?>

<form id="createProductFormClass" method="post">
    <select id="course_parent_id" name="course_parent_id" onchange="fetchTeachers();">
    <?php
    include("../db.php");
    $course_sql = "SELECT * FROM courses";
    $course_result = $conn->query($course_sql);
    echo "<option value='' " . (($actionClass === 'create_mode_class') ? 'selected' : '') . ">Select Course</option>";
    if ($course_result->num_rows > 0) {
        while ($course_row = $course_result->fetch_assoc()) {
            $selected = ($course_row['course_id'] == $course_parent_id) ? 'selected' : '';
            echo "<option value='" . $course_row['course_id'] . "' $selected>" . $course_row['course_name'] . "</option>";
        }
    }
    ?>
    </select><br>
    <select id="teacher_parent_id" name="teacher_parent_id">
    <?php
    include("../db.php");
    if ($actionClass == 'edit_mode_class') {
        echo "<option value=''>Select Course</option>";
        $teacher_sql = "SELECT * FROM teachers WHERE course_parent_id = $course_parent_id";
        $teacher_result = $conn->query($teacher_sql);
        if ($teacher_result->num_rows > 0) {
            while ($teacher_row = $teacher_result->fetch_assoc()) {
                $selected = ($teacher_row['teacher_id'] == $teacher_parent_id) ? 'selected' : '';
                echo "<option value='" . $teacher_row['teacher_id'] . "' $selected>" . $teacher_row['teacher_username'] . "</option>";
            }
        } else {
            echo "<option value='' selected>No teachers available</option>";
        }
    } else {
        echo "<option value='' selected>Select Teacher</option>";
    }
    ?>
    </select><br>
    <input type="time" id="start_time" name="start_time" <?php echo $actionClass !== 'create_mode_class' ? 'value="' . $start_time . '"' : ''; ?>><br>
    <input type="time" id="end_time" name="end_time" <?php echo $actionClass !== 'create_mode_class' ? 'value="' . $end_time . '"' : ''; ?>><br>
    <input type="date" id="date_of_class" name="date_of_class" <?php echo $actionClass !== 'create_mode_class' ? 'value="' . $date_of_class . '"' : ''; ?>><br>
    <select id="class_status" name="class_status">
        <option value="Select" <?php echo ($actionClass === 'create_mode_class') ? 'selected' : ''; ?>>Select</option>
        <option value="Upcoming" <?php echo ($actionClass === 'edit_mode_class' && $class_status === 'Upcoming') ? 'selected' : ''; ?>>Upcoming</option>
        <option value="Ongoing" <?php echo ($actionClass === 'edit_mode_class' && $class_status === 'Ongoing') ? 'selected' : ''; ?>>Ongoing</option>
        <option value="Finished" <?php echo ($actionClass === 'edit_mode_class' && $class_status === 'Finished') ? 'selected' : ''; ?>>Finished</option>
        <option value="Cancelled" <?php echo ($actionClass === 'edit_mode_class' && $class_status === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
    </select><br>
    <?php if ($actionClass == "edit_mode_class") { ?>
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionClass" value="<?php echo $actionClass; ?>" />

    <?php if ($actionClass == 'edit_mode_class') { ?>
        <button type="button" onclick="validateFormClass()">Update</button>
    <?php } elseif ($actionClass == 'create_mode_class') { ?>
        <button type="button" onclick="validateFormClass()">Create</button>
    <?php } ?>
</form>

</body>
</html>
