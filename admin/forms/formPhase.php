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
$actionPhase = isset($_GET['actionPhase']) ? $_GET['actionPhase'] : 'create_mode_phase';
$class_parent_id = '';
$user_parent_id = '';
$attendance = '';
$class_room_status = '';

if ($actionPhase == 'edit_mode_phase') {
    include("../db.php");

    $class_room_id = isset($_GET['class_room_id']) ? $_GET['class_room_id'] : null;
    if ($class_room_id !== null) {
        $my_sql  = "SELECT * FROM class_rooms WHERE class_room_id = $class_room_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $class_parent_id = $row["class_parent_id"];
            $user_parent_id = $row["user_parent_id"];
	    $attendance = $row["attendance"];
            $class_room_status = $row["class_room_status"];
        }
    }
}
?>

<form id="createProductFormPhase" method="post">
    <select id="class_parent_id" name="class_parent_id">
	<?php
	include("../db.php");
	$class_sql = "SELECT * FROM classes";
	$class_result = $conn->query($class_sql);
	echo "<option value='' " . (($actionPhase === 'create_mode_phase') ? 'selected' : '') . ">Select Class</option>";
	if ($class_result->num_rows > 0) {
    		while ($class_row = $class_result->fetch_assoc()) {
       		 $selected = ($class_row['class_id'] == $class_parent_id) ? 'selected' : '';
        	echo "<option value='" . $class_row['class_id'] . "' $selected>" . $class_row['date_of_class'] . "</option>";
    		}
	}
	?>
    </select><br>
    <select id="user_parent_id" name="user_parent_id">
        <?php
        include("../db.php");
        $user_sql = "SELECT * FROM users WHERE user_type='Student'";
        $user_result = $conn->query($user_sql);
        echo "<option value='' " . (($actionPhase === 'create_mode_phase') ? 'selected' : '') . ">Select Student</option>";
        if ($user_result->num_rows > 0) {
            while ($user_row = $user_result->fetch_assoc()) {
                $selected = ($user_row['user_id'] == $user_parent_id) ? 'selected' : '';
                echo "<option value='" . $user_row['user_id'] . "' $selected>" . $user_row['user_name'] . "</option>";
            }
        }
        ?>
    </select><br>
    <select id="attendance" name="attendance">
        <option value="Select" <?php echo ($actionPhase === 'create_mode_phase') ? 'selected' : ''; ?>>Select</option>
        <option value="Present" <?php echo ($actionPhase === 'edit_mode_phase' && $attendance === 'Present') ? 'selected' : ''; ?>>Present</option>
        <option value="Absent" <?php echo ($actionPhase === 'edit_mode_phase' && $attendance === 'Absent') ? 'selected' : ''; ?>>Absent</option>
        <option value="Late" <?php echo ($actionPhase === 'edit_mode_phase' && $attendance === 'Late') ? 'selected' : ''; ?>>Late</option>
    </select><br>
    <select id="class_room_status" name="class_room_status">
        <option value="Select" <?php echo ($actionPhase === 'create_mode_phase') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionPhase === 'edit_mode_phase' && $class_room_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionPhase === 'edit_mode_phase' && $class_room_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionPhase == "edit_mode_phase") { ?>
        <input type="hidden" name="class_room_id" value="<?php echo $class_room_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionPhase" value="<?php echo $actionPhase; ?>" />

    <?php if ($actionPhase == 'edit_mode_phase') { ?>
        <button type="button" onclick="validateFormPhase()">Update</button>
    <?php } elseif ($actionPhase == 'create_mode_phase') { ?>
        <button type="button" onclick="validateFormPhase()">Create</button>
    <?php } ?>
</form>

</body>
</html>
