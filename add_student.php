<?php
    require_once 'includes/header.php';
    require_once 'includes/config.php';

    $sql = "SELECT user_id, user_name FROM users WHERE user_type = 'Student'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="custom-main">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add Students to Class</h2>

        <form action="process_add_students.php" method="POST">
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
                                <td><?php echo $student['user_name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Add</button>
                <a href="class_details.php" class="btn btn-secondary">Return</a> 
            </div>
        </form>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
