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

        input[type="file"],
        input[type="date"],
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
$actionAssgn = isset($_GET['actionAssgn']) ? $_GET['actionAssgn'] : 'create_mode_assgn';
$task_desc = '';
$course_parent_id = '';
$date_parent_id = '';
$task_file= '';
$task_deadline = '';
$task_status = '';

include("../db.php");

if ($actionAssgn == 'edit_mode_assgn') {

    $task_id = isset($_GET['task_id']) ? $_GET['task_id'] : null;
    if ($task_id !== null) {
        $my_sql  = "SELECT * FROM class_tasks WHERE task_id = $task_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $task_desc = $row["task_desc"];
            $course_parent_id = $row["course_parent_id"];
            $date_parent_id = $row["date_parent_id"];
            $task_file = $row["task_file"];
            $task_deadline = $row["task_deadline"];
            $task_status = $row["task_status"];
        }
    }
}
?>

<form id="createProductFormAssgn" method="post" enctype="multipart/form-data">
    <textarea id="task_desc" name="task_desc" <?php echo $actionAssgn === 'create_mode_assgn' ? 'placeholder="Task Description"' : ''; ?>><?php echo $actionAssgn !== 'create_mode_assgn' ? $task_desc : ''; ?></textarea><br>
    <select id="course_parent_id" name="course_parent_id" onChange="fetchDates_task();">
    <?php
    require_once("../db.php");
    $course_sql = "SELECT * FROM courses";
    $course_result = $conn->query($course_sql);
    echo "<option value=''>Select Course</option>";
    if ($course_result->num_rows > 0) {
        while ($course_row = $course_result->fetch_assoc()) {
            $selected = ($course_row['course_id'] == $course_parent_id) ? 'selected' : '';
            echo "<option value='" . $course_row['course_id'] . "' $selected>" . $course_row['course_name'] . "</option>";
        }
    }
    ?>
    </select><br>
    <select id="date_parent_id" name="date_parent_id">
        <?php
        include("../db.php"); 
        if($actionAssgn == 'edit_mode_assgn'){ 
            echo "<option value=''>Select Class</option>";
            $class_sql = "SELECT c.class_id, c.date_of_class, crs.course_name 
                        FROM classes c
                        INNER JOIN courses crs ON c.course_parent_id = crs.course_id WHERE course_parent_id = $course_parent_id"; 
            $class_result = $conn->query($class_sql);
            if ($class_result->num_rows > 0) {
                while ($class_row = $class_result->fetch_assoc()) {
                    $selected = ($class_row['class_id'] == $date_parent_id) ? 'selected' : ''; 
                    $display_text = $class_row['date_of_class'] . ' (' . $class_row['course_name'] . ')';
                    $option_value = $class_row['class_id'];
                    $encoded_display_text = htmlspecialchars($display_text);
                    echo "<option value='$option_value' $selected>$encoded_display_text</option>";
                }
            } else {
                echo "<option value='' selected>No classes available</option>";
            }
        } else {
            echo "<option value='' selected>Select Class</option>";
        }
        ?>
    </select><br>
    <input type="file" id="task_file" name="task_file"><br>
    <input type="date" id="task_deadline" name="task_deadline" <?php echo $actionAssgn !== 'create_mode_assgn' ? 'value="' . $task_deadline . '"' : '';?>>
    <select id="task_status" name="task_status">
        <option value="Select" <?php echo ($actionAssgn === 'create_mode_assgn') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionAssgn === 'edit_mode_assgn' && $task_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionAssgn === 'edit_mode_assgn' && $task_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionAssgn == "edit_mode_assgn") { ?>
        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionAssgn" value="<?php echo $actionAssgn; ?>" />

    <button type="button" onclick="validateFormAssgn()"><?php echo ($actionAssgn == 'edit_mode_assgn') ? 'Update' : 'Create'; ?></button>
</form>

</body>
</html>