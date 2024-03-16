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
$actionLevel = isset($_GET['actionLevel']) ? $_GET['actionLevel'] : 'create_mode_level';
$level_name = '';
$level_status = '';

if ($actionLevel == 'edit_mode_level') {
    include("../db.php");

    $level_id = isset($_GET['level_id']) ? $_GET['level_id'] : null;
    if ($level_id !== null) {
        $my_sql  = "SELECT * FROM levels WHERE level_id = $level_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $level_name = $row["level_name"];
            $level_status = $row["level_status"];
        }
    }
}
?>

<form id="createProductFormLevel" method="post">
    <input type="text" id="level_name" name="level_name" <?php echo $actionLevel !== 'create_mode_level' ? 'value="' . $level_name . '"' : 'placeholder="Level Name"'; ?>><br>
    <select id="level_status" name="level_status">
        <option value="Select" <?php echo ($actionLevel === 'create_mode_level') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionLevel === 'edit_mode_level' && $level_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionLevel === 'edit_mode_level' && $level_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionLevel == "edit_mode_level") { ?>
        <input type="hidden" name="level_id" value="<?php echo $level_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionLevel" value="<?php echo $actionLevel; ?>" />

    <?php if ($actionLevel == 'edit_mode_level') { ?>
        <button type="button" onclick="validateFormLevel()">Update</button>
    <?php } elseif ($actionLevel == 'create_mode_level') { ?>
        <button type="button" onclick="validateFormLevel()">Create</button>
    <?php } ?>
</form>

</body>
</html>
