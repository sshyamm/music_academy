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

        fieldset {
            border: none;
            margin-bottom: 20px;
            display: inline-block;
        }

        legend {
            font-weight: bold;
        }

        .radio-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            display: inline-block; 
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        label {
            display: inline-block;
        }

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
$actionAge = isset($_GET['actionAge']) ? $_GET['actionAge'] : 'create_mode_age';
$age_group_name = '';
$age_group_status = '';

if ($actionAge == 'edit_mode_age') {
    include("../db.php");

    $age_group_id = isset($_GET['age_group_id']) ? $_GET['age_group_id'] : null;
    if ($age_group_id !== null) {
        $my_sql  = "SELECT * FROM age_groups WHERE age_group_id = $age_group_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $age_group_name = $row["age_group_name"];
            $age_group_status = $row["age_group_status"];
        }
    }
}
?>

<form id="createProductFormAge" method="post">
    <fieldset>
        <legend><strong>Age Group</strong></legend>
        <div class="radio-container">
            <input type="radio" id="age_group_6_10" name="age_group_name" value="6-10" <?php echo ($actionAge !== 'create_mode_age' && $age_group_name === '6-10') ? 'checked' : ''; ?>>
            <label for="age_group_6_10">6-10</label>
        </div>

        <div class="radio-container">
            <input type="radio" id="age_group_11_20" name="age_group_name" value="11-20" <?php echo ($actionAge !== 'create_mode_age' && $age_group_name === '11-20') ? 'checked' : ''; ?>>
            <label for="age_group_11_20">11-20</label>
        </div>

        <div class="radio-container">
            <input type="radio" id="age_group_21_30" name="age_group_name" value="21-30" <?php echo ($actionAge !== 'create_mode_age' && $age_group_name === '21-30') ? 'checked' : ''; ?>>
            <label for="age_group_21_30">21-30</label>
        </div>

        <div class="radio-container">
            <input type="radio" id="age_group_31_40" name="age_group_name" value="31-40" <?php echo ($actionAge !== 'create_mode_age' && $age_group_name === '31-40') ? 'checked' : ''; ?>>
            <label for="age_group_31_40">31-40</label>
        </div>
    </fieldset><br>
    <select id="age_group_status" name="age_group_status">
        <option value="Select" <?php echo ($actionAge === 'create_mode_age') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionAge === 'edit_mode_age' && $age_group_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionAge === 'edit_mode_age' && $age_group_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionAge == "edit_mode_age") { ?>
        <input type="hidden" name="age_group_id" value="<?php echo $age_group_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionAge" value="<?php echo $actionAge; ?>" />

    <?php if ($actionAge == 'edit_mode_age') { ?>
        <button type="button" onclick="validateFormAge()">Update</button>
    <?php } elseif ($actionAge == 'create_mode_age') { ?>
        <button type="button" onclick="validateFormAge()">Create</button>
    <?php } ?>
</form>

</body>
</html>
