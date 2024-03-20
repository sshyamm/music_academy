<?php
require_once 'includes/header.php';
require_once 'includes/config.php';

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';

$sql = "SELECT u.user_id, u.user_name 
        FROM users u
        JOIN interests i ON u.user_id = i.user_parent_id
        JOIN classes c ON i.interest_date = c.class_id
        WHERE u.user_type='Student'
        AND c.class_id = :class_id
        AND i.course_parent_id = c.course_parent_id";

$stmt = $db->prepare($sql);
$stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><input type="checkbox" name="selected_students[]" value="<?php echo $student['user_id']; ?>"></td>
                                <td><?php echo htmlspecialchars($student['user_name']); ?></td>
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
