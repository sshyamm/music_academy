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
        select,textarea {
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
$actionCourse = isset($_GET['actionCourse']) ? $_GET['actionCourse'] : 'create_mode_course';
$course_name = '';
$course_desc = '';
$course_img = '';
$course_icon = '';
$course_status = '';

if ($actionCourse == 'edit_mode_course') {
    include("../db.php");

    $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
    if ($course_id !== null) {
        $my_sql  = "SELECT * FROM courses WHERE course_id = $course_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $course_name = $row["course_name"];
            $course_desc = $row["course_desc"];
            $course_img = $row["course_img"];
            $course_icon = $row["course_icon"];
            $course_status = $row["course_status"];
        }
    }
}
?>

<form id="createProductFormCourse" method="post" enctype="multipart/form-data">
    <input type="text" id="course_name" name="course_name" <?php echo $actionCourse !== 'create_mode_course' ? 'value="' . $course_name . '"' : 'placeholder="Course Name"'; ?>><br>
    <textarea id="course_desc" name="course_desc" <?php echo $actionCourse === 'create_mode_course' ? 'placeholder="Course Description"' : ''; ?>><?php echo $actionCourse !== 'create_mode_course' ? $course_desc : ''; ?></textarea><br>
    <input type="file" id="course_img" name="course_img"><br>
    <input type="file" id="course_icon" name="course_icon"><br>
    <select id="course_status" name="course_status">
        <option value="Select" <?php echo ($actionCourse === 'create_mode_course') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionCourse === 'edit_mode_course' && $course_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionCourse === 'edit_mode_course' && $course_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionCourse == "edit_mode_course") { ?>
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionCourse" value="<?php echo $actionCourse; ?>" />

    <?php if ($actionCourse == 'edit_mode_course') { ?>
        <button type="button" onclick="validateFormCourse()">Update</button>
    <?php } elseif ($actionCourse == 'create_mode_course') { ?>
        <button type="button" onclick="validateFormCourse()">Create</button>
    <?php } ?>
</form>

</body>
</html>
