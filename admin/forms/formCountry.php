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
$actionCountry = isset($_GET['actionCountry']) ? $_GET['actionCountry'] : 'create_mode_country';
$level_name = '';
$level_status = '';

if ($actionCountry == 'edit_mode_country') {
    include("../db.php");

    $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : null;
    if ($country_id !== null) {
        $my_sql  = "SELECT * FROM countries WHERE country_id = $country_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $country_name = $row["country_name"];
            $country_status = $row["country_status"];
        }
    }
}
?>

<form id="createProductFormCountry" method="post">
    <input type="text" id="country_name" name="country_name" <?php echo $actionCountry !== 'create_mode_country' ? 'value="' . $country_name . '"' : 'placeholder="Country Name"'; ?>><br>
    <select id="country_status" name="country_status">
        <option value="Select" <?php echo ($actionCountry === 'create_mode_country') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionCountry === 'edit_mode_country' && $country_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionCountry === 'edit_mode_country' && $country_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionCountry == "edit_mode_country") { ?>
        <input type="hidden" name="country_id" value="<?php echo $country_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionCountry" value="<?php echo $actionCountry; ?>" />

    <?php if ($actionCountry == 'edit_mode_country') { ?>
        <button type="button" onclick="validateFormCountry()">Update</button>
    <?php } elseif ($actionCountry == 'create_mode_country') { ?>
        <button type="button" onclick="validateFormCountry()">Create</button>
    <?php } ?>
</form>

</body>
</html>
