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
$actionCmt = isset($_GET['actionCmt']) ? $_GET['actionCmt'] : 'create_mode_cmt';
$user_parent_id = '';
$course_parent_id = '';
$comment = '';
$comment_status = '';

if ($actionCmt == 'edit_mode_cmt') {
    include("../db.php");

    $comment_id = isset($_GET['comment_id']) ? $_GET['comment_id'] : null;
    if ($comment_id !== null) {
        $my_sql  = "SELECT * FROM comments WHERE comment_id = $comment_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $user_parent_id = $row["user_parent_id"];
            $course_parent_id = $row["course_parent_id"];
	        $comment = $row["comment"];
            $comment_status = $row["comment_status"];
        }
    }
}
?>

<form id="createProductFormCmt" method="post">
    <select id="user_parent_id" name="user_parent_id">
        <?php
        include("../db.php");
        $user_sql = "SELECT * FROM users";
        $user_result = $conn->query($user_sql);
        echo "<option value='' " . (($actionCmt === 'create_mode_cmt') ? 'selected' : '') . ">Select Student</option>";
        if ($user_result->num_rows > 0) {
            while ($user_row = $user_result->fetch_assoc()) {
                $selected = ($user_row['user_id'] == $user_parent_id) ? 'selected' : '';
                echo "<option value='" . $user_row['user_id'] . "' $selected>" . $user_row['user_name'] . "</option>";
            }
        }
        ?>
    </select><br>
    <textarea id="comment" name="comment" <?php echo $actionCmt === 'create_mode_cmt' ? 'placeholder="Comment Here"' : ''; ?>><?php echo $actionCmt !== 'create_mode_cmt' ? $comment : ''; ?></textarea><br>
    <select id="course_parent_id" name="course_parent_id">
	<?php
	include("../db.php");
	$course_sql = "SELECT * FROM courses";
	$course_result = $conn->query($course_sql);
	echo "<option value='' " . (($actionCmt === 'create_mode_cmt') ? 'selected' : '') . ">Select Course</option>";
	if ($course_result->num_rows > 0) {
    		while ($course_row = $course_result->fetch_assoc()) {
       		 $selected = ($course_row['course_id'] == $course_parent_id) ? 'selected' : '';
        	echo "<option value='" . $course_row['course_id'] . "' $selected>" . $course_row['course_name'] . "</option>";
    		}
	}
	?>
    </select><br>
    <select id="comment_status" name="comment_status">
        <option value="Select" <?php echo ($actionCmt === 'create_mode_cmt') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionCmt === 'edit_mode_cmt' && $comment_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionCmt === 'edit_mode_cmt' && $comment_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionCmt == "edit_mode_cmt") { ?>
        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionCmt" value="<?php echo $actionCmt; ?>" />

    <?php if ($actionCmt == 'edit_mode_cmt') { ?>
        <button type="button" onclick="validateFormCmt()">Update</button>
    <?php } elseif ($actionCmt == 'create_mode_cmt') { ?>
        <button type="button" onclick="validateFormCmt()">Create</button>
    <?php } ?>
</form>

</body>
</html>
