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
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="password"],
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
        #contract_container,#join_container {
            width: 90%;
            margin: auto;
            display: flex;
            align-items: center;
        }

        #contract_label,#join_label {
            width: 16%;
            text-align: left;
            padding-left: 10px;
            font-size: 14px;
        }

        #contract_date,#join_date {
            width: 85%;
        }
    </style>
</head>
<body>

<?php
$actionTeacher = isset($_GET['actionTeacher']) ? $_GET['actionTeacher'] : 'create_mode_teacher';
$teacher_username = '';
$teacher_password = '';
$teacher_phone = '';
$teacher_email = '';
$teacher_address = '';
$course_parent_id = '';
$qualification = '';
$teacher_exp = '';
$contract_date = '';
$current_salary = '';
$joined_date = '';
$teacher_status = '';

if ($actionTeacher == 'edit_mode_teacher') {
    include("../db.php");

    $teacher_id = isset($_GET['teacher_id']) ? $_GET['teacher_id'] : null;
    if ($teacher_id !== null) {
        $my_sql  = "SELECT * FROM teachers WHERE teacher_id = $teacher_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $teacher_username = $row["teacher_username"];
            $teacher_password = $row["teacher_password"];
            $teacher_phone = $row["teacher_phone"];
            $teacher_email = $row["teacher_email"];
            $teacher_address = $row["teacher_address"];
            $course_parent_id = $row["course_parent_id"];
            $qualification = $row["qualification"];
            $teacher_exp = $row["teacher_exp"];
            $contract_date = $row["contract_date"];
            $current_salary = $row["current_salary"];
            $join_date = $row["join_date"];
            $teacher_status = $row["teacher_status"];
        }
    }
}
?>
<form id="createProductFormTeacher" method="post">
    <input type="text" id="teacher_username" name="teacher_username" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $teacher_username . '"' : 'placeholder="Teacher Name"'; ?>><br>
    <input type="password" id="teacher_password" name="teacher_password" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $teacher_password . '"' : 'placeholder="Teacher Password"'; ?>><br>
    <input type="text" id="teacher_phone" name="teacher_phone" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $teacher_phone . '"' : 'placeholder="Teacher Phone"'; ?>><br>
    <input type="text" id="teacher_email" name="teacher_email" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $teacher_email . '"' : 'placeholder="Teacher Email"'; ?>><br>
    <input type="text" id="teacher_address" name="teacher_address" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $teacher_address . '"' : 'placeholder="Teacher Address"'; ?>><br>
    <select id="course_parent_id" name="course_parent_id">
	<?php
	include("../db.php");
	$course_sql = "SELECT * FROM courses";
	$course_result = $conn->query($course_sql);
	echo "<option value='' " . (($actionTeacher === 'create_mode_teacher') ? 'selected' : '') . ">Select Course</option>";
	if ($course_result->num_rows > 0) {
    		while ($course_row = $course_result->fetch_assoc()) {
       		 $selected = ($course_row['course_id'] == $course_parent_id) ? 'selected' : '';
        	echo "<option value='" . $course_row['course_id'] . "' $selected>" . $course_row['course_name'] . "</option>";
    		}
	}
	?>
    </select><br>
    <input type="text" id="qualification" name="qualification" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $qualification . '"' : 'placeholder="Teacher Qualification"'; ?>><br>
    <input type="number" id="teacher_exp" name="teacher_exp" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $teacher_exp . '"' : 'placeholder="Teacher Experience"'; ?>><br>
    <input type="number" id="current_salary" name="current_salary" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $current_salary . '"' : 'placeholder="Current Salary"'; ?>><br>
    <select id="teacher_status" name="teacher_status">
        <option value="Select" <?php echo ($actionTeacher === 'create_mode_teacher') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionTeacher === 'edit_mode_teacher' && $teacher_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionTeacher === 'edit_mode_teacher' && $teacher_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <div id="join_container">
        <label for="join_date" id="join_label">Joined Date :</label>
        <input type="date" id="join_date" name="join_date" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $join_date . '"' : '';?>>
    </div>
    <div id="contract_container">
        <label for="contract_date" id="contract_label">Contract Date :</label>
        <input type="date" id="contract_date" name="contract_date" <?php echo $actionTeacher !== 'create_mode_teacher' ? 'value="' . $contract_date . '"' : '';?>>
    </div>
    <?php if ($actionTeacher == "edit_mode_teacher") { ?>
        <input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionTeacher" value="<?php echo $actionTeacher; ?>" />

    <?php if ($actionTeacher == 'edit_mode_teacher') { ?>
        <button type="button" onclick="validateFormTeacher()">Update</button>
    <?php } elseif ($actionTeacher == 'create_mode_teacher') { ?>
        <button type="button" onclick="validateFormTeacher()">Create</button>
    <?php } ?>
</form>

</body>
</html>
