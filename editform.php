<?php
$user_name = '';
$email = '';
$phone_num = '';
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
$teacher_phone = '';
$teacher_email = '';
$teacher_address = '';
$qualification = '';
$teacher_exp = '';

require_once 'includes/config.php';

$user_parent_id = isset($_GET['user_parent_id']) ? $_GET['user_parent_id'] : null;
$user_type = isset($_GET['user_type']) ? $_GET['user_type'] : null;

if ($user_parent_id !== null && $user_type !== null) {
    $stmt = null;
    switch ($user_type) {
        case 'Student':
            $stmt = $db->prepare("SELECT s.*, us.user_name FROM students s LEFT JOIN users us ON s.user_parent_id = us.user_id WHERE user_parent_id = ?");
            break;
        case 'Teacher':
            $stmt = $db->prepare("SELECT t.*, us.user_name FROM teachers t LEFT JOIN users us ON t.user_parent_id = us.user_id WHERE user_parent_id = ?");
            break;
        default:
            break;
    }

    if ($stmt !== null) {
        $stmt->execute([$user_parent_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row !== false) {
            $user_name = $row["user_name"];
            $email = $row["email"];
            switch ($user_type) {
                case 'Student':
                    $phone_num = $row["phone_num"];
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
                    break;
                case 'Teacher':
                    $teacher_phone = $row["teacher_phone"];
                    $teacher_email = $row["teacher_email"];
                    $teacher_address = $row["teacher_address"];
                    $course_parent_id = $row["course_parent_id"];
                    $qualification = $row["qualification"];
                    $teacher_exp = $row["teacher_exp"];
                    break;
                default:
                    break;
            }
        }
    }
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-5 update-card">
                <h2 class="text-center mb-4">Edit Your Details</h2>
                <?php if ($user_type === 'Student') { ?>
                    <form id="myacc_form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_parent_id" value="<?php echo $user_parent_id; ?>" />
                        <input type="hidden" name="user_type" value="<?php echo $user_type; ?>" />
                        <span>&nbsp;</span>
                        <div class="section edit-section">
                            <h3 class="section-heading">Personal Information</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Username" id="user_name" name="user_name" value="<?php echo $user_name; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="<?php echo $email; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Phone Number" id="phone_num" name="phone_num" value="<?php echo $phone_num; ?>">
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
                                            <option value="">Select Age</option>
                                            <?php
                                            $age_sql = "SELECT * FROM age_groups";
                                            $age_result = $db->query($age_sql);
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
                                            <option value="">Select Course</option>
                                            <?php
                                            $course_sql = "SELECT * FROM courses";
                                            $course_result = $db->query($course_sql);
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
                                            <option value="">Select Level</option>
                                            <?php
                                            $level_sql = "SELECT * FROM levels";
                                            $level_result = $db->query($level_sql);
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
                                        <input type="text" class="form-control" placeholder="Emergency Contact" id="emergency_contact" name="emergency_contact" value="<?php echo $emergency_contact; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="blood_group" name="blood_group">
                                            <option value="">Select Blood Group</option>
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
                                <input type="text" class="form-control" placeholder="Address" id="address" name="address" value="<?php echo $address; ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="country_parent_id" name="country_parent_id" onChange="fetchStates();">
                                            <option value="">Select Country</option>
                                            <?php
                                            $country_sql = "SELECT * FROM countries";
                                            $country_result = $db->query($country_sql);
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
                                            <option value="">Select State</option>
                                            <?php
                                            if ($country_parent_id != '') {
                                                $state_sql = "SELECT * FROM states WHERE country_parent_id = $country_parent_id";
                                                $state_result = $db->query($state_sql);
                                                if ($state_result->rowCount() > 0) {
                                                    while ($state_row = $state_result->fetch(PDO::FETCH_ASSOC)) {
                                                        $selected = ($state_row['state_id'] == $state_parent_id) ? 'selected' : '';
                                                        echo "<option value='" . $state_row['state_id'] . "' $selected>" . $state_row['state_name'] . "</option>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="city_parent_id" name="city_parent_id">
                                            <option value="">Select City</option>
                                            <?php
                                            if ($state_parent_id != '') {
                                                $city_sql = "SELECT * FROM cities WHERE state_parent_id = $state_parent_id";
                                                $city_result = $db->query($city_sql);
                                                if ($city_result->rowCount() > 0) {
                                                    while ($city_row = $city_result->fetch(PDO::FETCH_ASSOC)) {
                                                        $selected = ($city_row['city_id'] == $city_parent_id) ? 'selected' : '';
                                                        echo "<option value='" . $city_row['city_id'] . "' $selected>" . $city_row['city_name'] . "</option>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </select><br>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Pincode" id="pincode" name="pincode" value="<?php echo $pincode; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span>&nbsp;</span>
                        <div class="text-center edit-button">
                            <button type="submit" id="editfrmBtn" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </form>
                <?php } elseif ($user_type === 'Teacher') { ?>
                    <form id="myacc_form_teach" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="user_parent_id" value="<?php echo $user_parent_id; ?>" />
                        <input type="hidden" name="user_type" value="<?php echo $user_type; ?>" />
                        <span>&nbsp;</span>
                        <div class="section edit-section">
                            <h3 class="section-heading">Personal Information</h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Username" id="user_name" name="user_name" value="<?php echo $user_name; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Email" id="teacher_email" name="teacher_email" value="<?php echo $teacher_email; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Phone Number" id="teacher_phone" name="teacher_phone" value="<?php echo $teacher_phone; ?>">
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
                                        <input type="text" class="form-control" placeholder="Qualification" id="qualification" name="qualification" value="<?php echo $qualification; ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control" id="course_parent_id" name="course_parent_id">
                                            <option value="">Select Course</option>
                                            <?php
                                            $course_sql = "SELECT * FROM courses";
                                            $course_result = $db->query($course_sql);
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
                                        <input type="number" class="form-control" placeholder="Experience in years" id="teacher_exp" name="teacher_exp" value="<?php echo $teacher_exp; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <span>&nbsp;</span>
                        <div class="section edit-address">
                            <h3 class="section-heading">Address Details</h3>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Address" id="teacher_address" name="teacher_address" value="<?php echo $teacher_address; ?>">
                            </div>
                        </div>
                        <span>&nbsp;</span>
                        <div class="text-center edit-button">
                            <button type="submit" id="editfrmBtn_teach" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
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
