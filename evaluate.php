<?php
require_once 'includes/header.php';
require_once 'includes/config.php';
?>

<main class="custom-main">
    <div class="container mt-5">
        <div class="card mb-4 border-1 rounded-lg shadow-lg">
            <div class="card-header bg-warning text-black rounded-top">
                Task Evaluation
            </div>
            <div class="card-body">
            <?php
            if (isset($_GET['task_manager_id'])) {
                $task_manager_id = $_GET['task_manager_id'];

                $sql_task_details = "SELECT ct.task_desc, u.user_name, tm.last_updated, tm.submit_status, tm.remark, tm.comment, tm.grading, tm.file_path
                                    FROM tasks tm
                                    JOIN class_tasks ct ON tm.task_parent_id = ct.task_id
                                    JOIN users u ON tm.user_parent_id = u.user_id
                                    WHERE tm.task_manager_id = :task_manager_id";
                $stmt_task_details = $db->prepare($sql_task_details);
                $stmt_task_details->bindParam(':task_manager_id', $task_manager_id);
                $stmt_task_details->execute();
                $task_details = $stmt_task_details->fetch(PDO::FETCH_ASSOC);

                if ($task_details) {
                    ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Task Description :</strong> <?php echo $task_details['task_desc']; ?></p>
                            <p><strong>Student Name :</strong> <?php echo $task_details['user_name']; ?></p>
                            <p><strong>Last Updated :</strong> <?php echo $task_details['last_updated']; ?></p>
                            <?php if (!empty($task_details['file_path']) && file_exists("/var/www/html/music_academy/admin/getForms/uploads/" . $task_details['file_path'])) : ?>
                                <p><strong>File :</strong> <a href="/music_academy/admin/getForms/uploads/<?php echo $task_details['file_path']; ?>" download><?php echo $task_details['file_path']; ?></a></p>
                            <?php else : ?>
                                <p><strong>File :</strong> No File Submitted</p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Remark :</strong> <?php echo $task_details['remark']; ?></p>
                            <p><strong>Comment :</strong> <?php echo $task_details['comment']; ?></p>
                            <p><strong>Grading :</strong> <?php echo $task_details['grading']; ?></p>
                            <p><strong>Submit Status :</strong> <?php echo $task_details['submit_status']; ?></p>
                            <button type="button" class="btn btn-primary evaluate-btn" id="evaluate-Btn">Evaluate</button>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<p>No task details found for the provided Task Manager ID.</p>";
                }
            } else {
                echo "<p>Task Manager ID is not provided.</p>";
            }
            ?>
            </div>
        </div>
    </div>
</main>
<h2 id="signup-message">&nbsp;</h2>
<div class="editform"></div>

<?php require_once 'includes/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#evaluate-Btn').click(function() {
            var task_manager_id = '<?php echo $task_manager_id; ?>';
            $('.editform').load('evaluate_form.php?task_manager_id=' + task_manager_id);
        });
    });
</script>
