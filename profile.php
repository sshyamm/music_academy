<?php require_once 'includes/header.php'; ?>

<?php
require_once 'includes/config.php';
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
?>

<div class="jumbotron jumbotron-fluid jumbotron11">
  <div class="container">
    <h1 class="display-4">My Profile (<?php echo $_SESSION['user_name']; ?>)</h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
      </ol>
    </nav>
  </div>
</div>

<?php 
if ($user_type === 'Student') {
  $sql = "SELECT s.*, 
                  ag.age_group_name, 
                  c.course_name, 
                  l.level_name, 
                  ci.city_name, 
                  st.state_name, 
                  co.country_name,
                  us.user_name
          FROM students s
          LEFT JOIN users us ON s.user_parent_id = us.user_id
          LEFT JOIN age_groups ag ON s.age_group_parent_id = ag.age_group_id
          LEFT JOIN courses c ON s.course_parent_id = c.course_id
          LEFT JOIN levels l ON s.level_parent_id = l.level_id
          LEFT JOIN cities ci ON s.city_parent_id = ci.city_id
          LEFT JOIN states st ON s.state_parent_id = st.state_id
          LEFT JOIN countries co ON s.country_parent_id = co.country_id
          WHERE s.user_parent_id = ?"; 
                
  $stmt = $db->prepare($sql);
  $stmt->execute([$user_id]);
  $student = $stmt->fetch(PDO::FETCH_ASSOC);
  ?>

  <main class="custom-main">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="card border-1 rounded-lg" style="box-shadow: 0 8px 12px rgba(0, 0, 0, 0.8);">
            <img src="img/profile.jpg" class="card-img-top mx-auto d-block rounded-circle" alt="Profile Picture" style="width: 150px; height: 150px;">
            <div class="card-body text-center">
              <h2 class="card-title mb-4"><?php echo $student['user_name']; ?></h2>
              <p class="card-text mb-4"><strong>Location: </strong><?php echo $student['city_name']; ?>, <?php echo $student['state_name']; ?>, <?php echo $student['country_name']; ?></p>
              <p class="card-text mb-4"><strong>Email:</strong> <?php echo $student['email']; ?></p>
              <p class="card-text mb-4"><strong>Bio:</strong> I am an enthusiastic student</p>
              <div class="text-center">
                <button class="btn btn-primary btn-lg mt-3" id="editDetailsBtn">Edit your Details</button>
              </div>
            </div>  
            
            <div id="hiddenInfo" style="display: none;">
              <div class="card-body">
                
                <div class="container">
                  <div class="row">
                    <div class="col-md-6">
                      <?php if (!empty($student)) { ?>
                        <table class="table">
                          <tbody>
                            <tr>
                              <th scope="row">Name</th>
                              <td><?php echo $student['user_name']; ?></td>
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
                      <?php } else {
                        echo "Student details not found.";
                      } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="position-absolute" style="top: 0; right: 0;">
              <div class="card-body p-0">
                <div class="card-footer text-muted text-right bg-transparent border-0">
                  <button id="toggleInfoBtn" class="more-info btn btn-link text-primary" style="text-decoration: none;">More Info</button>
                </div>
              </div>
            </div>
          </div>
          <span>&nbsp;</span>
          <h2 id="signup-message">&nbsp;</h2>
          <div class="editf">
            <div class="editform"></div>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php } elseif ($user_type === 'Teacher') {
  $sql = "SELECT s.*, 
                  c.course_name,
                  us.user_name
                  FROM teachers s
          LEFT JOIN users us ON s.user_parent_id = us.user_id
          LEFT JOIN courses c ON s.course_parent_id = c.course_id
          WHERE s.user_parent_id = ?";

  $stmt = $db->prepare($sql);
  $stmt->execute([$user_id]);
  $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
  ?>

  <main class="custom-main">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
        <div class="card border-1 rounded-lg" style="box-shadow: 0 8px 12px rgba(0, 0, 0, 0.8);">
            <img src="img/profile.jpg" class="card-img-top mx-auto d-block rounded-circle" alt="Profile Picture" style="width: 150px; height: 150px;">
            <div class="card-body text-center">
              <h2 class="card-title mb-4"><?php echo $teacher['user_name']; ?></h2>
              <p class="card-text mb-4"><strong>Email:</strong> <?php echo $teacher['teacher_email']; ?></p>
              <p class="card-text mb-4"><strong>Bio:</strong> I am an enthusiastic teacher</p>
              <div class="text-center">
                <button class="btn btn-primary btn-lg mt-3" id="editDetailsBtn">Edit your Details</button>
              </div>
            </div>  
            
            <div id="hiddenInfo" style="display: none;">
              <div class="card-body">
                
                <div class="container">
                  <div class="row">
                    <div class="col-md-6">
                      <?php if (!empty($teacher)) { ?>
                        <table class="table">
                          <tbody>
                            <tr>
                              <th scope="row">Name</th>
                              <td><?php echo $teacher['user_name']; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Phone number</th>
                              <td><?php echo $teacher['teacher_phone']; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Email</th>
                              <td><?php echo $teacher['teacher_email']; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Address</th>
                              <td><?php echo $teacher['teacher_address']; ?></td>
                            </tr>
                            <tr>
                              <th scope="row">Course Name</th>
                              <td><?php echo $teacher['course_name']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                      <table class="table">
                        <tbody>
                          <tr>
                            <th scope="row">Qualification</th>
                            <td><?php echo $teacher['qualification']; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Experience</th>
                            <td><?php echo $teacher['teacher_exp']; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Contract date</th>
                            <td><?php echo $teacher['contract_date']; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Current Salary</th>
                            <td><?php echo $teacher['current_salary']; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Joined Date</th>
                            <td><?php echo $teacher['join_date']; ?></td>
                          </tr>
                          <tr>
                            <th scope="row">Status</th>
                            <td><?php echo $teacher['teacher_status']; ?></td>
                          </tr>
                        </tbody>
                      </table>
                      <?php } else {
                        echo "Teacher details not found.";
                      } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="position-absolute" style="top: 0; right: 0;">
              <div class="card-body p-0">
                <div class="card-footer text-muted text-right bg-transparent border-0">
                  <button id="toggleInfoBtn" class="more-info btn btn-link text-primary" style="text-decoration: none;">More Info</button>
                </div>
              </div>
            </div>
          </div>
          <span>&nbsp;</span>
          <h2 id="signup-message">&nbsp;</h2>
          <div class="editf">
            <div class="editform"></div>
          </div>
        </div>
      </div>
    </div>
  </main>

<?php } else {
    echo "User type not recognized.";
}
?>
<?php require_once 'includes/footer.php'; ?>

<script>
  document.getElementById("toggleInfoBtn").addEventListener("click", function() {
    var hiddenInfo = document.getElementById("hiddenInfo");
    if (hiddenInfo.style.display === "none") {
      hiddenInfo.style.display = "block";
      this.innerHTML = "Hide Info";
    } else {
      hiddenInfo.style.display = "none";
      this.innerHTML = "More Info";
    }
  });

  $(document).ready(function(){
    $('#editDetailsBtn').click(function(){
        var user_parent_id = <?php echo $user_id; ?>;
        var user_type = '<?php echo $user_type; ?>';
        $('.editform').load('editform.php?user_parent_id=' + user_parent_id + '&user_type=' + user_type);
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
