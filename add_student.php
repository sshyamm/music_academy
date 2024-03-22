<?php
require_once 'includes/header.php';
require_once 'includes/config.php';

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';

$sql_students_interests = "SELECT u.user_id, u.user_name
       FROM users u
       JOIN interests i ON u.user_id = i.user_parent_id
       JOIN classes c ON i.course_parent_id = c.course_parent_id
       WHERE u.user_type='Student'
       AND c.class_id = :class_id";

$sql_students_classrooms = "SELECT u.user_id, u.user_name
FROM users u
JOIN class_rooms c ON u.user_id = c.user_parent_id
WHERE c.class_parent_id = :class_id";

$stmt_students_interests = $db->prepare($sql_students_interests);
$stmt_students_interests->bindParam(':class_id', $class_id, PDO::PARAM_INT);
$stmt_students_interests->execute();
$students_interests = $stmt_students_interests->fetchAll(PDO::FETCH_ASSOC);

$stmt_students_classrooms = $db->prepare($sql_students_classrooms);
$stmt_students_classrooms->bindParam(':class_id', $class_id, PDO::PARAM_INT);
$stmt_students_classrooms->execute();
$students_classrooms = $stmt_students_classrooms->fetchAll(PDO::FETCH_ASSOC);

$students = array_merge($students_interests, $students_classrooms);
$students = array_unique($students, SORT_REGULAR); 
?>

<main class="custom-main">
   <div class="container mt-5">
       <h2 class="text-center mb-4">Add Students to Class</h2>

       <form id="addStudentsForm" method="POST">
           <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
          
           <div class="table-responsive">
               <table class="table table-bordered">
                   <thead>
                       <tr>
                           <th>Select</th>
                           <th>User Name</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php foreach ($students as $student):
                           $sql = "SELECT COUNT(*) AS count
                                   FROM class_rooms cr
                                   WHERE cr.class_parent_id = :class_id
                                   AND cr.user_parent_id = :user_id";

                           $stmt = $db->prepare($sql);
                           $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                           $stmt->bindParam(':user_id', $student['user_id'], PDO::PARAM_INT);
                           $stmt->execute();
                           $result = $stmt->fetch(PDO::FETCH_ASSOC);
                           $alreadyAdded = ($result['count'] > 0);
                       ?>
                           <tr>
                               <td>
                                   <input type="checkbox" name="selected_students[]" value="<?php echo $student['user_id']; ?>" <?php echo $alreadyAdded ? 'disabled' : ''; ?>>
                               </td>
                               <td>
                                   <?php echo htmlspecialchars($student['user_name']); ?>
                                   <?php if ($alreadyAdded): ?>
                                       <span class="text-danger">(Already added to the class)</span>
                                   <?php endif; ?>
                               </td>
                           </tr>
                       <?php endforeach; ?>
                   </tbody>
               </table>
           </div>
           <div class="text-center">
               <button type="submit" id="addStudentsBtn" class="btn btn-primary">Add</button>
               <a href="class_details.php?class_id=<?php echo $class_id; ?>" class="btn btn-secondary">Return</a>
           </div>
       </form>
   </div>
</main>

<script>
$(document).ready(function() {
   $('#addStudentsForm').on('submit', function(e) {
       e.preventDefault();
      
       var formData = $(this).serialize();
      
       $.ajax({
           url: 'get_add_student.php',
           type: 'POST',
           data: formData,
           success: function(response) {
               if (response === 'success') {
                   var class_id = "<?php echo $class_id; ?>";
                   window.location.href = 'class_details.php?class_id=' + class_id;
               } else {
                   alert("Please select at least one student");
               }
           },
           error: function() {
               alert("An error occurred while processing your request.");
           }
       });
   });
});
</script>

<?php require_once 'includes/footer.php'; ?>
