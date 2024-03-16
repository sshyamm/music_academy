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
        input[type="number"],
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
$actionState = isset($_GET['actionState']) ? $_GET['actionState'] : 'create_mode_state';
$country_parent_id = '';
$state_name = '';
$state_status = '';

if ($actionState == 'edit_mode_state') {
    include("../db.php");

    $state_id = isset($_GET['state_id']) ? $_GET['state_id'] : null;
    if ($state_id !== null) {
        $my_sql  = "SELECT * FROM states WHERE state_id = $state_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $country_parent_id = $row["country_parent_id"];
            $state_name = $row["state_name"];
            $state_status = $row["state_status"];
        }
    }
}
?>

<form id="createProductFormState" method="post">
    <select id="country_parent_id" name="country_parent_id">
	<?php
	include("../db.php");
	$country_sql = "SELECT * FROM countries";
	$country_result = $conn->query($country_sql);
	echo "<option value='' " . (($actionState === 'create_mode_state') ? 'selected' : '') . ">Select Country</option>";
	if ($country_result->num_rows > 0) {
    		while ($country_row = $country_result->fetch_assoc()) {
       		 $selected = ($country_row['country_id'] == $country_parent_id) ? 'selected' : '';
        	echo "<option value='" . $country_row['country_id'] . "' $selected>" . $country_row['country_name'] . "</option>";
    		}
	}
	?>
    </select><br>
    <input type="text" id="state_name" name="state_name" <?php echo $actionState !== 'create_mode_state' ? 'value="' . $state_name . '"' : 'placeholder="State Name"'; ?>><br>
    <select id="state_status" name="state_status">
        <option value="Select" <?php echo ($actionState === 'create_mode_state') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionState === 'edit_mode_state' && $state_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionState === 'edit_mode_state' && $state_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionState == "edit_mode_state") { ?>
        <input type="hidden" name="state_id" value="<?php echo $state_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionState" value="<?php echo $actionState; ?>" />

    <?php if ($actionState == 'edit_mode_state') { ?>
        <button type="button" onclick="validateFormState()">Update</button>
    <?php } elseif ($actionState == 'create_mode_state') { ?>
        <button type="button" onclick="validateFormState()">Create</button>
    <?php } ?>
</form>

</body>
</html>
