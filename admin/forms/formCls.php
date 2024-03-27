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
$actionCls = isset($_GET['actionCls']) ? $_GET['actionCls'] : 'create_mode_cls';
$user_parent_id = '';
$class_parent_id = '';
$comment = '';
$comment_status = '';

if ($actionCls == 'edit_mode_cls') {
    include("../db.php");

    $comment_id = isset($_GET['comment_id']) ? $_GET['comment_id'] : null;
    if ($comment_id !== null) {
        $my_sql  = "SELECT * FROM class_comments WHERE comment_id = $comment_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $user_parent_id = $row["user_parent_id"];
            $class_parent_id = $row["class_parent_id"];
	        $comment = $row["comment"];
            $comment_status = $row["comment_status"];
        }
    }
}
?>

<form id="createProductFormCls" method="post">
    <select id="user_parent_id" name="user_parent_id">
        <?php
        include("../db.php");
        $user_sql = "SELECT * FROM users";
        $user_result = $conn->query($user_sql);
        echo "<option value='' " . (($actionCls === 'create_mode_cls') ? 'selected' : '') . ">Select Student</option>";
        if ($user_result->num_rows > 0) {
            while ($user_row = $user_result->fetch_assoc()) {
                $selected = ($user_row['user_id'] == $user_parent_id) ? 'selected' : '';
                echo "<option value='" . $user_row['user_id'] . "' $selected>" . $user_row['user_name'] . "</option>";
            }
        }
        ?>
    </select><br>
    <textarea id="comment" name="comment" <?php echo $actionCls === 'create_mode_cls' ? 'placeholder="Comment Here"' : ''; ?>><?php echo $actionCls !== 'create_mode_cls' ? $comment : ''; ?></textarea><br>
    <select id="class_parent_id" name="class_parent_id">
        <?php
        include("../db.php"); 
        $class_sql = "SELECT c.class_id, c.date_of_class, crs.course_name 
                    FROM classes c
                    INNER JOIN courses crs ON c.course_parent_id = crs.course_id"; 
        $class_result = $conn->query($class_sql);
        echo "<option value='' " . (($actionCls === 'create_mode_cls') ? 'selected' : '') . ">Select Class Date</option>";
        if ($class_result->num_rows > 0) {
            while ($class_row = $class_result->fetch_assoc()) {
                $selected = ($class_row['class_id'] == $class_parent_id) ? 'selected' : ''; 
                $display_text = $class_row['date_of_class'] . ' (' . $class_row['course_name'] . ')';
                $option_value = $class_row['class_id'];
                $encoded_display_text = htmlspecialchars($display_text);
                echo "<option value='$option_value' $selected>$encoded_display_text</option>";
            }
        }
        ?>
    </select><br>
    <select id="comment_status" name="comment_status">
        <option value="Select" <?php echo ($actionCls === 'create_mode_cls') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionCls === 'edit_mode_cls' && $comment_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionCls === 'edit_mode_cls' && $comment_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionCls == "edit_mode_cls") { ?>
        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionCls" value="<?php echo $actionCls; ?>" />

    <?php if ($actionCls == 'edit_mode_cls') { ?>
        <button type="button" onclick="validateFormCls()">Update</button>
    <?php } elseif ($actionCls == 'create_mode_cls') { ?>
        <button type="button" onclick="validateFormCls()">Create</button>
    <?php } ?>
</form>

</body>
</html>
