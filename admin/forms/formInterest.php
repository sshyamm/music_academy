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
$actionInt = isset($_GET['actionInt']) ? $_GET['actionInt'] : 'create_mode_int';
$user_parent_id = '';
$course_parent_id = '';
$level_parent_id = '';
$interest_date= '';
$interest_status = '';

include("../db.php");

if ($actionInt == 'edit_mode_int') {

    $interest_id = isset($_GET['interest_id']) ? $_GET['interest_id'] : null;
    if ($interest_id !== null) {
        $my_sql  = "SELECT * FROM interests WHERE interest_id = $interest_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $user_parent_id = $row["user_parent_id"];
            $course_parent_id = $row["course_parent_id"];
            $level_parent_id = $row["level_parent_id"];
            $interest_date = $row["interest_date"];
            $interest_status = $row["interest_status"];
        }
    }
}
?>

<form id="createProductFormInterest" method="post">
    <select id="user_parent_id" name="user_parent_id">
        <?php
        include("../db.php");
        $user_sql = "SELECT * FROM users WHERE user_type='Student'";
        $user_result = $conn->query($user_sql);
        echo "<option value='' " . (($actionInt === 'create_mode_int') ? 'selected' : '') . ">Select Student</option>";
        if ($user_result->num_rows > 0) {
            while ($user_row = $user_result->fetch_assoc()) {
                $selected = ($user_row['user_id'] == $user_parent_id) ? 'selected' : '';
                echo "<option value='" . $user_row['user_id'] . "' $selected>" . $user_row['user_name'] . "</option>";
            }
        }
        ?>
    </select><br>
    <select id="course_parent_id" name="course_parent_id" onChange="fetchDates();">
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
    <select id="level_parent_id" name="level_parent_id">
        <?php
        $level_sql = "SELECT * FROM levels";
        $level_result = $conn->query($level_sql);
        echo "<option value='Select Level' " . (($actionInt === 'create_mode_int') ? 'selected' : '') . ">Select Level</option>";
        if ($level_result->num_rows > 0) {
            while ($level_row = $level_result->fetch_assoc()) {
                $selected = ($level_row['level_id'] == $level_parent_id) ? 'selected' : '';
                echo "<option value='" . $level_row['level_id'] . "' $selected>" . $level_row['level_name'] . "</option>";
            }
        }
        ?>
    </select><br>
    <select id="interest_date" name="interest_date">
        <?php
        include("../db.php"); 
        if($actionInt == 'edit_mode_int'){ 
            echo "<option value=''>Select Class</option>";
            $class_sql = "SELECT c.class_id, c.date_of_class, crs.course_name 
                        FROM classes c
                        INNER JOIN courses crs ON c.course_parent_id = crs.course_id WHERE course_parent_id = $course_parent_id"; 
            $class_result = $conn->query($class_sql);
            if ($class_result->num_rows > 0) {
                while ($class_row = $class_result->fetch_assoc()) {
                    $selected = ($class_row['class_id'] == $interest_date) ? 'selected' : ''; 
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
    <select id="interest_status" name="interest_status">
        <option value="Select" <?php echo ($actionInt === 'create_mode_int') ? 'selected' : ''; ?>>Select</option>
        <option value="Joined" <?php echo ($actionInt === 'edit_mode_int' && $interest_status === 'Joined') ? 'selected' : ''; ?>>Joined</option>
        <option value="New" <?php echo ($actionInt === 'edit_mode_int' && $interest_status === 'New') ? 'selected' : ''; ?>>New</option>
    </select><br>
    <?php if ($actionInt == "edit_mode_int") { ?>
        <input type="hidden" name="interest_id" value="<?php echo $interest_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionInt" value="<?php echo $actionInt; ?>" />

    <?php if ($actionInt == 'edit_mode_int') { ?>
        <button type="button" onclick="validateFormInterest()">Update</button>
    <?php } elseif ($actionInt == 'create_mode_int') { ?>
        <button type="button" onclick="validateFormInterest()">Create</button>
    <?php } ?>
</form>

</body>
</html>
