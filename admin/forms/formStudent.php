<html>
<head>
    <style>
        #formStudentContainer {
            width: 50%;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }

        #formStudentContainer input[type="text"],
        #formStudentContainer input[type="password"],
        #formStudentContainer input[type="number"],
        #formStudentContainer select {
            padding: 10px;
            margin: 10px;
            width: 90%;
            box-sizing: border-box;
            border: 1px solid #ccc;
        }

        #formStudentContainer button[type="button"] {
            padding: 10px;
            font-size: 16px;
            margin: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        #formStudentContainer button[type="button"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div id="formStudentContainer">
<?php
$actionStudent = isset($_GET['actionStudent']) ? $_GET['actionStudent'] : 'create_mode_student';
$user_parent_id = '';
$phone_num = '';
$email = '';
$age_group_parent_id = '';
$course_parent_id = '';
$level_parent_id = '';
$emergency_contact = '';
$blood_group = '';
$address = '';
$pincode = '';
$city_parent_id = '';
$state_parent_id = '';
$country_parent_id = '';
$student_status = '';

if ($actionStudent == 'edit_mode_student') {
    include("../db.php");

    $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
    if ($student_id !== null) {
        $my_sql  = "SELECT * FROM students WHERE student_id = $student_id";
        $res_sql = $conn->query($my_sql);

        if ($res_sql->num_rows === 1) {
            $row = $res_sql->fetch_assoc();
            $user_parent_id = $row["user_parent_id"];
            $phone_num = $row["phone_num"];
            $email = $row["email"];
            $age_group_parent_id = $row["age_group_parent_id"];
            $course_parent_id = $row["course_parent_id"];
            $level_parent_id = $row["level_parent_id"];
            $emergency_contact = $row["emergency_contact"];
            $blood_group = $row["blood_group"];
            $address = $row["address"];
            $pincode = $row["pincode"];
            $city_parent_id = $row["city_parent_id"];
            $state_parent_id = $row["state_parent_id"];
            $country_parent_id = $row["country_parent_id"];
            $student_status = $row["student_status"];
        }
    }
}
?>

<form id="createProductFormStudent" method="post">
    <select id="user_parent_id" name="user_parent_id">
        <?php
        include("../db.php");
        $user_sql = "SELECT * FROM users WHERE user_type='Student'";
        $user_result = $conn->query($user_sql);
        echo "<option value='' " . (($actionStudent === 'create_mode_student') ? 'selected' : '') . ">Select Student</option>";
        if ($user_result->num_rows > 0) {
            while ($user_row = $user_result->fetch_assoc()) {
                $selected = ($user_row['user_id'] == $user_parent_id) ? 'selected' : '';
                echo "<option value='" . $user_row['user_id'] . "' $selected>" . $user_row['user_name'] . "</option>";
            }
        }
        ?>
    </select><br>
    <input type="text" id="phone_num" name="phone_num" <?php echo $actionStudent !== 'create_mode_student' ? 'value="' . $phone_num . '"' : 'placeholder="Phone Number"'; ?>><br>
    <input type="text" id="email" name="email" <?php echo $actionStudent !== 'create_mode_student' ? 'value="' . $email . '"' : 'placeholder="Email"'; ?>><br>
    <select id="age_group_parent_id" name="age_group_parent_id">
	<?php
	include("../db.php");
	$age_sql = "SELECT * FROM age_groups";
	$age_result = $conn->query($age_sql);
	echo "<option value='' " . (($actionStudent === 'create_mode_student') ? 'selected' : '') . ">Select Age</option>";
	if ($age_result->num_rows > 0) {
    		while ($age_row = $age_result->fetch_assoc()) {
       		 $selected = ($age_row['age_group_id'] == $age_group_parent_id) ? 'selected' : '';
        	echo "<option value='" . $age_row['age_group_id'] . "' $selected>" . $age_row['age_group_name'] . "</option>";
    		}
	}
	?>
    </select><br>
    <select id="course_parent_id" name="course_parent_id">
	<?php
	include("../db.php");
	$course_sql = "SELECT * FROM courses";
	$course_result = $conn->query($course_sql);
	echo "<option value='' " . (($actionStudent === 'create_mode_student') ? 'selected' : '') . ">Select Course</option>";
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
	include("../db.php");
	$level_sql = "SELECT * FROM levels";
	$level_result = $conn->query($level_sql);
	echo "<option value='' " . (($actionStudent === 'create_mode_student') ? 'selected' : '') . ">Select Level</option>";
	if ($level_result->num_rows > 0) {
    		while ($level_row = $level_result->fetch_assoc()) {
       		 $selected = ($level_row['level_id'] == $level_parent_id) ? 'selected' : '';
        	echo "<option value='" . $level_row['level_id'] . "' $selected>" . $level_row['level_name'] . "</option>";
    		}
	}
	?>
    </select><br>
    <input type="text" id="emergency_contact" name="emergency_contact" <?php echo $actionStudent !== 'create_mode_student' ? 'value="' . $emergency_contact . '"' : 'placeholder="Emergency Contact"'; ?>><br>
    <select id="blood_group" name="blood_group">
        <option value="Select Blood Group" <?php echo ($actionStudent === 'create_mode_student') ? 'selected' : ''; ?>>Select Blood Group</option>
        <option value="A+" <?php echo ($actionStudent === 'edit_mode_student' && $blood_group === 'A+') ? 'selected' : ''; ?>>A+</option>
        <option value="A-" <?php echo ($actionStudent === 'edit_mode_student' && $blood_group === 'A-') ? 'selected' : ''; ?>>A-</option>
        <option value="B+" <?php echo ($actionStudent === 'edit_mode_student' && $blood_group === 'B+') ? 'selected' : ''; ?>>B+</option>
        <option value="B-" <?php echo ($actionStudent === 'edit_mode_student' && $blood_group === 'B-') ? 'selected' : ''; ?>>B-</option>
        <option value="O-" <?php echo ($actionStudent === 'edit_mode_student' && $blood_group === 'O-') ? 'selected' : ''; ?>>O-</option>
        <option value="O+" <?php echo ($actionStudent === 'edit_mode_student' && $blood_group === 'O+') ? 'selected' : ''; ?>>O+</option>
        <option value="AB+" <?php echo ($actionStudent === 'edit_mode_student' && $blood_group === 'AB+') ? 'selected' : ''; ?>>AB+</option>
        <option value="AB-" <?php echo ($actionStudent === 'edit_mode_student' && $blood_group === 'AB-') ? 'selected' : ''; ?>>AB-</option>
    </select><br>
    <input type="text" id="address" name="address" <?php echo $actionStudent !== 'create_mode_student' ? 'value="' . $address . '"' : 'placeholder="Address"'; ?>><br>
    <input type="text" id="pincode" name="pincode" <?php echo $actionStudent !== 'create_mode_student' ? 'value="' . $pincode . '"' : 'placeholder="Pincode"'; ?>><br>
    <select id="country_parent_id" name="country_parent_id" onChange="fetchStates();">
    <?php
    include("../db.php");
    $country_sql = "SELECT * FROM countries";
    $country_result = $conn->query($country_sql);
    echo "<option value='' " . (($actionStudent === 'create_mode_student') ? 'selected' : '') . ">Select Country</option>";
    if ($country_result->num_rows > 0) {
        while ($country_row = $country_result->fetch_assoc()) {
            $selected = ($country_row['country_id'] == $country_parent_id) ? 'selected' : '';
            echo "<option value='" . $country_row['country_id'] . "' $selected>" . $country_row['country_name'] . "</option>";
        }
    }
    ?>
    </select><br>
    <select id="state_parent_id" name="state_parent_id" onChange="fetchCities();">
    <?php
    include("../db.php");
    if ($actionStudent == 'edit_mode_student') {
        echo "<option value=''>Select State</option>";
        $state_sql = "SELECT * FROM states WHERE country_parent_id = $country_parent_id";
        $state_result = $conn->query($state_sql);
        if ($state_result->num_rows > 0) {
            while ($state_row = $state_result->fetch_assoc()) {
                $selected = ($state_row['state_id'] == $state_parent_id) ? 'selected' : '';
                echo "<option value='" . $state_row['state_id'] . "' $selected>" . $state_row['state_name'] . "</option>";
            }
        } else {
            echo "<option value='' selected>No states available</option>";
        }
    } else {
        echo "<option value='' selected>Select State</option>";
    }
    ?>
    </select><br>
    <select id="city_parent_id" name="city_parent_id">
    <?php
    include("../db.php");
    if ($actionStudent == 'edit_mode_student') {
        echo "<option value=''>Select City</option>";
        $city_sql = "SELECT * FROM cities WHERE state_parent_id = $state_parent_id";
        $city_result = $conn->query($city_sql);
        if ($city_result->num_rows > 0) {
            while ($city_row = $city_result->fetch_assoc()) {
                $selected = ($city_row['city_id'] == $city_parent_id) ? 'selected' : '';
                echo "<option value='" . $city_row['city_id'] . "' $selected>" . $city_row['city_name'] . "</option>";
            }
        } else {
            echo "<option value='' selected>No cities available</option>";
        }
    } else {
        echo "<option value='' selected>Select City</option>";
    }
    ?>
    </select><br>
    <select id="student_status" name="student_status">
        <option value="Select" <?php echo ($actionStudent === 'create_mode_student') ? 'selected' : ''; ?>>Select</option>
        <option value="Enquired" <?php echo ($actionStudent === 'edit_mode_student' && $student_status === 'Enquired') ? 'selected' : ''; ?>>Enquired</option>
        <option value="Active" <?php echo ($actionStudent === 'edit_mode_student' && $student_status === 'Active') ? 'selected' : ''; ?>>Active</option>
        <option value="Inactive" <?php echo ($actionStudent === 'edit_mode_student' && $student_status === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br>
    <?php if ($actionStudent == "edit_mode_student") { ?>
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>" />
    <?php } ?>
    <input type="hidden" name="actionStudent" value="<?php echo $actionStudent; ?>" />

    <?php if ($actionStudent == 'edit_mode_student') { ?>
        <button type="button" onclick="validateFormStudent()">Update</button>
    <?php } elseif ($actionStudent == 'create_mode_student') { ?>
        <button type="button" onclick="validateFormStudent()">Create</button>
    <?php } ?>
</form>
</div>
</body>
</html>
