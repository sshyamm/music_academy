<?php require_once 'includes/header.php'; ?>
<main class="custom-main">
    <span>&nbsp;</span>
    <h2 style="text-align: center; font-weight: bold;">MY details</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php
                require_once 'includes/config.php';

                $student_id = 3; 
                $sql = "SELECT s.*, 
                                ag.age_group_name, 
                                c.course_name, 
                                l.level_name, 
                                ci.city_name, 
                                st.state_name, 
                                co.country_name
                        FROM students s
                        LEFT JOIN age_groups ag ON s.age_group_parent_id = ag.age_group_id
                        LEFT JOIN courses c ON s.course_parent_id = c.course_id
                        LEFT JOIN levels l ON s.level_parent_id = l.level_id
                        LEFT JOIN cities ci ON s.city_parent_id = ci.city_id
                        LEFT JOIN states st ON s.state_parent_id = st.state_id
                        LEFT JOIN countries co ON s.country_parent_id = co.country_id
                        WHERE s.student_id = ?";
                
                $stmt = $db->prepare($sql);
                $stmt->execute([$student_id]);
                $student = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($student)) {
                ?>
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Name</th>
                            <td><?php echo $student['student_username']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Phone number</th>
                            <td><?php echo $student['phone_num']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td><?php echo $student['email']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Age-group</th>
                            <td><?php echo $student['age_group_name']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Course Name</th>
                            <td><?php echo $student['course_name']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Level Name</th>
                            <td><?php echo $student['level_name']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td><?php echo $student['student_status']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Joined</th>
                            <td><?php echo $student['joined_date']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Emergency Contact</th>
                            <td><?php echo $student['emergency_contact']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Blood Group</th>
                            <td><?php echo $student['blood_group']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Address</th>
                            <td><?php echo $student['address']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Pincode</th>
                            <td><?php echo $student['pincode']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Country</th>
                            <td><?php echo $student['country_name']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">State</th>
                            <td><?php echo $student['state_name']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">City</th>
                            <td><?php echo $student['city_name']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php
                } else {
                    echo "Student details not found.";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button class="btn btn-primary btn-lg mt-3" id="editDetailsBtn">Edit your Details</button>
    </div>
    <span>&nbsp;</span>
    <h2 id="signup-message">&nbsp;</h2>
    <div class="editf">
        <div class="editform"></div>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
$(document).ready(function(){
    $('#editDetailsBtn').click(function(){
        var student_id = 3; 
        $('.editform').load('editform.php?student_id=' + student_id);
    });
});
function fetchStates() {
        var country_parent_id = $('#country_parent_id').val();
        $.ajax({
            url: 'get_states.php',
            method: 'POST',
            data: { country_parent_id: country_parent_id },
            success: function(response) {
                $('#state_parent_id').html(response);
            },
        });
}

function fetchCities() {
        var state_parent_id = $('#state_parent_id').val();
        $.ajax({
            url: 'get_cities.php',
            method: 'POST',
            data: { state_parent_id: state_parent_id },
            success: function(response) {
                $('#city_parent_id').html(response);
            },
        });
}
</script>
</body>
</html>
