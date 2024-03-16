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
        input[type="file"],
        input[type="datetime-local"],
        select, textarea {
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
$actionTask = isset($_GET['actionTask']) ? $_GET['actionTask'] : 'create_mode_task';
$task_title = '';
$task_desc = '';
$file_path = '';
$task_status = '';
$assigned_to = '';
$assigned_by = '';
$deadline = '';
$priority = '';
$created_at = '';
$updated_at = '';
$completed_at = '';
$estimated_hours = '';

if ($actionTask == 'edit_mode_task') {
    include("../db.php");

    $task_id = isset($_GET['task_id']) ? $_GET['task_id'] : null;
    if ($task_id !== null) {
        $my_sql  = "SELECT * FROM tasks WHERE task_id = $task_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $task_title = $row["task_title"];
            $task_desc = $row["task_desc"];
            $assigned_to = $row["assigned_to"];
            $assigned_by = $row["assigned_by"];
            $deadline = $row["deadline"];
            $priority = $row["priority"];
            $estimated_hours = $row["estimated_hours"];
            $file_path = $row["file_path"];
            $task_status = $row["task_status"];
        }
    }
}
?>

<form id="createProductFormTask" method="post" enctype="multipart/form-data">
    <input type="text" id="task_title" name="task_title" <?php echo $actionTask !== 'create_mode_task' ? 'value="' . $task_title . '"' : 'placeholder="Task Title"'; ?>><br>
    <textarea id="task_desc" name="task_desc" <?php echo $actionTask === 'create_mode_task' ? 'placeholder="Task Description"' : ''; ?>><?php echo $actionTask !== 'create_mode_task' ? $task_desc : ''; ?></textarea><br>
    <select id="assigned_to" name="assigned_to">
	<?php
	include("../db.php");
	$student_sql = "SELECT * FROM students";
	$student_result = $conn->query($student_sql);
	echo "<option value='' " . (($actionTask === 'create_mode_task') ? 'selected' : '') . ">Select Student</option>";
	if ($student_result->num_rows > 0) {
    		while ($student_row = $student_result->fetch_assoc()) {
       		 $selected = ($student_row['student_id'] == $assigned_to) ? 'selected' : '';
        	echo "<option value='" . $student_row['student_id'] . "' $selected>" . $student_row['student_username'] . "</option>";
    		}
	}
	?>
    </select><br>
    <select id="assigned_by" name="assigned_by">
	<?php
	include("../db.php");
	$teacher_sql = "SELECT * FROM teachers";
	$teacher_result = $conn->query($teacher_sql);
	echo "<option value='' " . (($actionTask === 'create_mode_task') ? 'selected' : '') . ">Select Teacher</option>";
	if ($teacher_result->num_rows > 0) {
    		while ($teacher_row = $teacher_result->fetch_assoc()) {
       		 $selected = ($teacher_row['teacher_id'] == $assigned_by) ? 'selected' : '';
        	echo "<option value='" . $teacher_row['teacher_id'] . "' $selected>" . $teacher_row['teacher_username'] . "</option>";
    		}
	}
	?>
    </select><br>
    <input type="date" id="deadline" name="deadline" <?php echo $actionTask !== 'create_mode_task' ? 'value="' . $deadline . '"' : 'placeholder="Deadline"'; ?>><br>
    <select id="priority" name="priority">
        <option value="Select" <?php echo ($actionTask === 'create_mode_task') ? 'selected' : ''; ?>>Select</option>
        <option value="Critical" <?php echo ($actionTask === 'edit_mode_task' && $priority === 'Critical') ? 'selected' : ''; ?>>Critical</option>
        <option value="High" <?php echo ($actionTask === 'edit_mode_task' && $priority === 'High') ? 'selected' : ''; ?>>High</option>
        <option value="Moderate" <?php echo ($actionTask === 'edit_mode_task' && $priority === 'Moderate') ? 'selected' : ''; ?>>Moderate</option>
        <option value="Less" <?php echo ($actionTask === 'edit_mode_task' && $priority === 'Less') ? 'selected' : ''; ?>>Less</option>
    </select><br>
    <input type="number" id="estimated_hours" name="estimated_hours" <?php echo $actionTask !== 'create_mode_task' ? 'value="' . $estimated_hours . '"' : 'placeholder="Estimated Hours"'; ?>><br>
    <input type="file" id="file_path" name="file_path"><br>
    <select id="task_status" name="task_status">
        <option value="Select" <?php echo ($actionTask === 'create_mode_task') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionTask === 'edit_mode_task' && $task_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionTask === 'edit_mode_task' && $task_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
        <option value="Completed" <?php echo ($actionTask === 'edit_mode_task' && $task_status === 'Completed') ? 'selected' : ''; ?>>Completed</option>
    </select><br>
    <?php if ($actionTask == "edit_mode_task") { ?>
        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionTask" value="<?php echo $actionTask; ?>" />

    <?php if ($actionTask == 'edit_mode_task') { ?>
        <button type="button" onclick="validateFormTask()">Update</button>
    <?php } elseif ($actionTask == 'create_mode_task') { ?>
        <button type="button" onclick="validateFormTask()">Create</button>
    <?php } ?>
</form>

</body>
</html>
