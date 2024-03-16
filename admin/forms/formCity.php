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
$actionCity = isset($_GET['actionCity']) ? $_GET['actionCity'] : 'create_mode_city';
$state_parent_id = '';
$city_name = '';
$city_status = '';

if ($actionCity == 'edit_mode_city') {
    include("../db.php");

    $city_id = isset($_GET['city_id']) ? $_GET['city_id'] : null;
    if ($city_id !== null) {
        $my_sql  = "SELECT city_id, state_parent_id, city_name, city_status FROM cities WHERE city_id = $city_id"; 
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $state_parent_id = $row["state_parent_id"]; 
            $city_name = $row["city_name"];
            $city_status = $row["city_status"];
        }
    }
}
?>

<form id="createProductFormCity" method="post">
	<select id="state_parent_id" name="state_parent_id">
    		<?php
    		include("../db.php");
   	   	$state_sql = "SELECT * FROM states";
    		$state_result = $conn->query($state_sql);
    		echo "<option value='' " . (($actionCity === 'create_mode_city') ? 'selected' : '') . ">Select State</option>";
    		if ($state_result->num_rows > 0) {
        		while ($state_row = $state_result->fetch_assoc()) {
            			$selected = ($state_row['state_id'] == $state_parent_id) ? 'selected' : '';
            			echo "<option value='" . $state_row['state_id'] . "' $selected>" . $state_row['state_name'] . "</option>";
        		}
    		}
    		?>
	</select><br>
    <input type="text" id="city_name" name="city_name" <?php echo $actionCity !== 'create_mode_city' ? 'value="' . $city_name . '"' : 'placeholder="City Name"'; ?>><br>
    <select id="city_status" name="city_status">
        <option value="Select" <?php echo ($actionCity === 'create_mode_city') ? 'selected' : ''; ?>>Select</option>
        <option value="Active" <?php echo ($actionCity === 'edit_mode_city' && $city_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionCity === 'edit_mode_city' && $city_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionCity == "edit_mode_city") { ?>
        <input type="hidden" name="city_id" value="<?php echo $city_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionCity" value="<?php echo $actionCity; ?>" />

    <?php if ($actionCity == 'edit_mode_city') { ?>
        <button type="button" onclick="validateFormCity()">Update</button>
    <?php } elseif ($actionCity == 'create_mode_city') { ?>
        <button type="button" onclick="validateFormCity()">Create</button>
    <?php } ?>
</form>

</body>
</html>
