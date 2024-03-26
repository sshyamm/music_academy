<?php
$comment = '';
$grading = '';

require_once 'includes/config.php';

$task_manager_id = isset($_GET['task_manager_id']) ? $_GET['task_manager_id'] : null;

if ($task_manager_id !== null) {
    $stmt = $db->prepare("SELECT comment, grading FROM tasks WHERE task_manager_id = ?");
    
    if ($stmt !== false) {
        $stmt->execute([$task_manager_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row !== false) {
            $comment = $row["comment"];
            $grading = $row["grading"];
        } else {
            echo "No data found for the provided Task Manager ID.";
        }
    } else {
        echo "Failed to prepare SQL statement.";
    }
} else {
    echo "Task Manager ID is not provided.";
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-5 update-card">
                <h2 class="text-center mb-4">Evaluate/Grade</h2>
                <form id="grade_form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="task_manager_id" value="<?php echo $task_manager_id; ?>" />
                    <span>&nbsp;</span>
                    <div class="section edit-section">
                        <h3 class="section-heading">Comment</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Comment" id="comment" name="comment"><?php echo $comment; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span>&nbsp;</span>
                    <div class="section edit-section">
                        <h3 class="section-heading">Grading</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Grade" id="grading" name="grading" value="<?php echo $grading; ?>">
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
    $(document).ready(function() {
        $('#grade_form').submit(function(e) {
            e.preventDefault(); 
            var comment = $('#comment').val().trim();
        
            if (comment === '') {
                showMessage("Comment is mandatory.");
                return; 
            }
            var formData = $(this).serialize(); 
            
            $.ajax({
                type: 'POST',
                url: 'update_grade.php',
                data: formData,
                success: function(response) {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        $('#task_desc').val('');
                        $('#task_file').val('');
                        showMessage(jsonResponse.message); 
                        location.reload();
                    } else {
                        showMessage("An error occurred: " + jsonResponse.message); 
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); 
                }
            });
        });
    });
    function showMessage(message) {
        $('#signup-message').text(message);
        setTimeout(function() {
            $('#signup-message').text('');
        }, 2500);
    }
</script>
