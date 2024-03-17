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
    </style>
</head>
<body>

<?php
$actionUser = isset($_GET['actionUser']) ? $_GET['actionUser'] : 'create_mode_user';
$user_name = '';
$user_password = '';
$user_type = '';
$user_status = '';

if ($actionUser == 'edit_mode_user') {
    include("../db.php");

    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
    if ($user_id !== null) {
        $my_sql  = "SELECT * FROM users WHERE user_id = $user_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $user_name = $row["user_name"];
            $user_password = $row["user_password"];
            $user_type = $row["user_type"];
            $user_status = $row["user_status"];
        }
    }
}
?>

<form id="createProductFormUser" method="post">
    <input type="text" id="user_name" name="user_name" <?php echo $actionUser === 'edit_mode_user' ? 'value="' . $user_name . '"' : 'placeholder="User Name"'; ?>><br>
    <input type="password" id="user_password" name="user_password" <?php echo $actionUser === 'edit_mode_user' ? 'value="' . $user_password . '"' : 'placeholder="User Password"'; ?>><br>
    <select id="user_type" name="user_type">
        <option value="Select" <?php echo ($actionUser === 'create_mode_user') ? 'selected' : ''; ?>>Select</option>
        <option value="Student" <?php echo ($actionUser === 'edit_mode_user' && $user_type === 'Student') ? 'selected' : ''; ?>>Student</option>
        <option value="Teacher" <?php echo ($actionUser === 'edit_mode_user' && $user_type === 'Teacher') ? 'selected' : ''; ?>>Teacher</option>
    </select><br>
    <select id="user_status" name="user_status">
        <option value="Select" <?php echo ($actionUser === 'create_mode_user') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionUser === 'edit_mode_user' && $user_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionUser === 'edit_mode_user' && $user_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionUser == "edit_mode_user") { ?>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionUser" value="<?php echo $actionUser; ?>" />

    <?php if ($actionUser == 'edit_mode_user') { ?>
        <button type="button" onclick="validateFormUser()">Update</button>
    <?php } elseif ($actionUser == 'create_mode_user') { ?>
        <button type="button" onclick="validateFormUser()">Create</button>
    <?php } ?>
</form>

</body>
</html>
