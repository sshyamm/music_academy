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
$actionImg = isset($_GET['actionImg']) ? $_GET['actionImg'] : 'create_mode_img';
$image_name = '';
$image_path = '';
$image_status = '';

if ($actionImg == 'edit_mode_img') {
    include("../db.php");

    $image_id = isset($_GET['image_id']) ? $_GET['image_id'] : null;
    if ($image_id !== null) {
        $my_sql  = "SELECT * FROM images WHERE image_id = $image_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $image_name = $row["image_name"];
            $image_path = $row["image_path"];
            $image_status = $row["image_status"];
        }
    }
}
?>

<form id="createProductFormImg" method="post" enctype="multipart/form-data">
    <input type="text" id="image_name" name="image_name" <?php echo $actionImg !== 'create_mode_img' ? 'value="' . $image_name . '"' : 'placeholder="Image Name"'; ?>><br>
    <input type="file" id="image_path" name="image_path"><br>
    <select id="image_status" name="image_status">
        <option value="Select" <?php echo ($actionImg === 'create_mode_img') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionImg === 'edit_mode_img' && $image_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Jumbotron" <?php echo ($actionImg === 'edit_mode_img' && $image_status === 'Jumbotron') ? 'selected' : ''; ?>>Jumbotron</option>
        <option value="Inactive" <?php echo ($actionImg === 'edit_mode_img' && $image_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionImg == "edit_mode_img") { ?>
        <input type="hidden" name="image_id" value="<?php echo $image_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionImg" value="<?php echo $actionImg; ?>" />

    <?php if ($actionImg == 'edit_mode_img') { ?>
        <button type="button" onclick="validateFormImg()">Update</button>
    <?php } elseif ($actionImg == 'create_mode_img') { ?>
        <button type="button" onclick="validateFormImg()">Create</button>
    <?php } ?>
</form>

</body>
</html>
