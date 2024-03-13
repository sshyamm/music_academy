<?php
$student_username = '';
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

require_once 'includes/config.php';

$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
if ($student_id !== null) {
    $stmt = $db->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->execute([$student_id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        $student_username = $row["student_username"];
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
    }
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-5 update-card">
                <h2 class="text-center mb-4">Edit Your Details</h2>
                <form id="myacc_form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>" />
                    <span>&nbsp;</span>
                    <div class="section edit-section">
                        <h3 class="section-heading">Personal Information</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Student Username" id="student_username" name="student_username" value="<?php echo $student_username; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo $email; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Phone Number" id="phone_num" name="phone_num" value="<?php echo $phone_num; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span>&nbsp;</span>
                    <div class="section edit-academic">
                        <h3 class="section-heading">Academic Details</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" id="age_group_parent_id" name="age_group_parent_id">
                                        <?php
                                        $age_sql = "SELECT * FROM age_groups";
                                        $age_result = $db->query($age_sql);
                                        echo "<option>Select Age</option>";
                                        if ($age_result->rowCount() > 0) {
                                            while ($age_row = $age_result->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($age_row['age_group_id'] == $age_group_parent_id) ? 'selected' : '';
                                                echo "<option value='" . $age_row['age_group_id'] . "' $selected>" . $age_row['age_group_name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" id="course_parent_id" name="course_parent_id">
                                        <?php
                                        $course_sql = "SELECT * FROM courses";
                                        $course_result = $db->query($course_sql);
                                        echo "<option>Select Course</option>";
                                        if ($course_result->rowCount() > 0) {
                                            while ($course_row = $course_result->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($course_row['course_id'] == $course_parent_id) ? 'selected' : '';
                                                echo "<option value='" . $course_row['course_id'] . "' $selected>" . $course_row['course_name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control" id="level_parent_id" name="level_parent_id">
                                        <?php
                                        $level_sql = "SELECT * FROM levels";
                                        $level_result = $db->query($level_sql);
                                        echo "<option>Select Level</option>";
                                        if ($level_result->rowCount() > 0) {
                                            while ($level_row = $level_result->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($level_row['level_id'] == $level_parent_id) ? 'selected' : '';
                                                echo "<option value='" . $level_row['level_id'] . "' $selected>" . $level_row['level_name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span>&nbsp;</span>
                    <div class="section edit-emergency">
                        <h3 class="section-heading">Emergency Contact</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Emergency Contact" id="emergency_contact" name="emergency_contact" value="<?php echo $emergency_contact; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <select class="form-control" id="blood_group" name="blood_group">
                                    <option>Select Blood Group</option>
                                    <option value="A+" <?php echo ($blood_group === 'A+') ? 'selected' : ''; ?>>A+</option>
                                    <option value="A-" <?php echo ($blood_group === 'A-') ? 'selected' : ''; ?>>A-</option>
                                    <option value="B+" <?php echo ($blood_group === 'B+') ? 'selected' : ''; ?>>B+</option>
                                    <option value="B-" <?php echo ($blood_group === 'B-') ? 'selected' : ''; ?>>B-</option>
                                    <option value="O-" <?php echo ($blood_group === 'O-') ? 'selected' : ''; ?>>O-</option>
                                    <option value="O+" <?php echo ($blood_group === 'O+') ? 'selected' : ''; ?>>O+</option>
                                    <option value="AB+" <?php echo ($blood_group === 'AB+') ? 'selected' : ''; ?>>AB+</option>
                                    <option value="AB-" <?php echo ($blood_group === 'AB-') ? 'selected' : ''; ?>>AB-</option>
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span>&nbsp;</span>
                    <div class="section edit-address">
                        <h3 class="section-heading">Address Details</h3>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Address" id="address" name="address" value="<?php echo $address; ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" id="country_parent_id" name="country_parent_id" onChange="fetchStates();">
                                        <?php
                                        $country_sql = "SELECT * FROM countries";
                                        $country_result = $db->query($country_sql);
                                        echo "<option>Select Country</option>";
                                        if ($country_result->rowCount() > 0) {
                                            while ($country_row = $country_result->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($country_row['country_id'] == $country_parent_id) ? 'selected' : '';
                                                echo "<option value='" . $country_row['country_id'] . "' $selected>" . $country_row['country_name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" id="state_parent_id" name="state_parent_id" onChange="fetchCities();">
                                        <?php
                                        echo "<option>Select State</option>";
                                        $state_sql = "SELECT * FROM states WHERE country_parent_id = $country_parent_id";
                                        $state_result = $db->query($state_sql);
                                        if ($state_result->rowCount() > 0) {
                                            while ($state_row = $state_result->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($state_row['state_id'] == $state_parent_id) ? 'selected' : '';
                                                echo "<option value='" . $state_row['state_id'] . "' $selected>" . $state_row['state_name'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value='' selected>No states available</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" id="city_parent_id" name="city_parent_id">
                                        <?php
                                        echo "<option>Select City</option>";
                                        $city_sql = "SELECT * FROM cities WHERE state_parent_id = $state_parent_id";
                                        $city_result = $db->query($city_sql);
                                        if ($city_result->rowCount() > 0) {
                                            while ($city_row = $city_result->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($city_row['city_id'] == $city_parent_id) ? 'selected' : '';
                                                echo "<option value='" . $city_row['city_id'] . "' $selected>" . $city_row['city_name'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value='' selected>No cities available</option>";
                                        }
                                        ?>
                                    </select><br>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Pincode" id="pincode" name="pincode" value="<?php echo $pincode; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span>&nbsp;</span>
                    <div class="text-center edit-button">
                        <button type="submit" id="editfrmBtn" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#myacc_form').submit(function(event) {
        event.preventDefault(); 

        $.ajax({
            url: 'api/edit_student.php',
            type: 'POST',
            data: $(this).serialize(), 
            success: function(response) {
                if (response.error) {
                    $('#signup-message').text(response.error);
                } else {
                    $('#signup-message').text(response.Message);
                }
                setTimeout(function() {
                    $('#signup-message').text('');
                    location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred while processing your request.");
            }
        });
    });
});
</script>
