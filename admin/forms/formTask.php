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
        input[type="file"],
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
$task_parent_id = '';
$user_parent_id = '';
$remark = '';
$comment = '';
$file_path = '';
$grading = '';
$deadline = '';
$last_updated = '';
$submit_status = '';

if ($actionTask == 'edit_mode_task') {
    include("../db.php");

    $task_manager_id = isset($_GET['task_manager_id']) ? $_GET['task_manager_id'] : null;
    if ($task_manager_id !== null) {
        $my_sql  = "SELECT * FROM tasks WHERE task_manager_id = $task_manager_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $task_parent_id = $row["task_parent_id"];
            $user_parent_id = $row["user_parent_id"];
            $remark = $row["remark"];
            $comment = $row["comment"];
            $file_path = $row["file_path"];
            $grading = $row["grading"];
            $last_updated = $row["last_updated"];
            $submit_status = $row["submit_status"];
        }
    }
}
?>

<form id="createProductFormTask" method="post" enctype="multipart/form-data">
    <select id="task_parent_id" name="task_parent_id">
    <?php
    include("../db.php");
    $task_sql = "SELECT * FROM class_tasks";
    $task_result = $conn->query($task_sql);
    echo "<option value='' " . (($actionTask === 'create_mode_task') ? 'selected' : '') . ">Select Task</option>";
    if ($task_result->num_rows > 0) {
        while ($task_row = $task_result->fetch_assoc()) {
            $selected = ($task_row['task_id'] == $task_parent_id) ? 'selected' : '';
            echo "<option value='" . $task_row['task_id'] . "' $selected>" . $task_row['task_desc'] . "</option>";
        }
    }
    ?>
    </select><br>
    <select id="user_parent_id" name="user_parent_id">
        <?php
        include("../db.php");
        $user_sql = "SELECT * FROM users WHERE user_type='Student'";
        $user_result = $conn->query($user_sql);
        echo "<option value='' " . (($actionTask === 'create_mode_task') ? 'selected' : '') . ">Select Student</option>";
        if ($user_result->num_rows > 0) {
            while ($user_row = $user_result->fetch_assoc()) {
                $selected = ($user_row['user_id'] == $user_parent_id) ? 'selected' : '';
                echo "<option value='" . $user_row['user_id'] . "' $selected>" . $user_row['user_name'] . "</option>";
            }
        }
        ?>
    </select><br>
    <textarea id="remark" name="remark" <?php echo $actionTask === 'create_mode_task' ? 'placeholder="Task Remark by Students"' : ''; ?>><?php echo $actionTask !== 'create_mode_task' ? $remark : ''; ?></textarea><br>
    <textarea id="comment" name="comment" <?php echo $actionTask === 'create_mode_task' ? 'placeholder="Comment by Teachers"' : ''; ?>><?php echo $actionTask !== 'create_mode_task' ? $comment : ''; ?></textarea><br>
    <input type="file" id="file_path" name="file_path"><br>
    <input type="text" id="grading" name="grading" <?php echo $actionTask !== 'create_mode_task' ? 'value="' . $grading . '"' : 'placeholder="Grading by Teachers"'; ?>><br>
    <select id="submit_status" name="submit_status">
        <option value="Select" <?php echo ($actionTask === 'create_mode_task') ? 'selected' : ''; ?>>Select</option>
        <option value="Pending" <?php echo ($actionTask === 'edit_mode_task' && $submit_status === 'Pending') ? 'selected' : ''; ?>>Pending</option>
        <option value="Submitted For Review" <?php echo ($actionTask === 'edit_mode_task' && $submit_status === 'Submitted For Review') ? 'selected' : ''; ?>>Submitted For Review</option>
        <option value="Graded & Completed" <?php echo ($actionTask === 'edit_mode_task' && $submit_status === 'Graded & Completed') ? 'selected' : ''; ?>>Graded & Completed</option>
    </select><br>
    <?php if ($actionTask == "edit_mode_task") { ?>
        <input type="hidden" name="task_manager_id" value="<?php echo $task_manager_id; ?>" />
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
