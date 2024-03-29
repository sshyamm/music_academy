<?php 
require_once 'includes/header.php';
require_once 'includes/config.php';

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : ''; 
$edit_task_id = isset($_GET['edit_task_id']) ? $_GET['edit_task_id'] : '';

$task_desc = '';
$task_deadline = '';
if (!empty($edit_task_id)) {
    $sql = "SELECT task_desc,task_deadline FROM class_tasks WHERE task_id = :task_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':task_id', $edit_task_id);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($task) {
        $task_desc = $task['task_desc'];
        $task_deadline = $task['task_deadline'];
    } else {
        echo "Task details not found for the provided edit_task_id.";
        exit();
    }
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<main class="custom-main">
<span>&nbsp;</span>
<h2 id="signup-message">&nbsp;</h2>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
            <div class="card" style="box-shadow: 0 0.8rem 3rem rgba(0, 0, 0, 0.4); border-radius: 1.5rem;">
                <div class="card-header bg-warning text-dark">
                <?php echo !empty($edit_task_id) ? 'Edit Task' : 'Upload Task'; ?>
                </div>
                <div class="card-body">
                <form id="uploadForm" name="uploadForm" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                    <label for="task_desc" class="form-label">Task Description</label>
                    <textarea class="form-control" id="task_desc" rows="3"><?php echo $task_desc; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="task_deadline" class="form-label">Task Deadline</label>
                        <input class="form-control" type="date" id="task_deadline" name="task_deadline" value="<?php echo $task_deadline; ?>">
                    </div>
                    <div class="mb-3">
                    <label for="task_file" class="form-label">Task File</label>
                    <input class="form-control" type="file" id="task_file">
                    </div>
                    <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="upBtn"><?php echo !empty($edit_task_id) ? 'Update' : 'Upload'; ?></button><span>&nbsp;</span>
                    <button type="reset" class="btn btn-secondary">Reset</button><span>&nbsp;</span>
                    <button type="button" class="btn btn-danger" onclick="window.location.href = 'class_details.php?class_id=<?php echo $class_id; ?>'">Return</button>
                    </div>
                    <div id="progressContainer" class="mt-3" style="display: none;">
                    <div class="progress" style="height: 12px;">
                        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
$(document).ready(function() {
    $('#upBtn').click(function() {
        handleFormData();
    });
});

function handleFormData() {
    var task_desc = $('#task_desc').val().trim();
    var task_deadline = $('#task_deadline').val().trim();
    var alertMessage = "";
    if (task_desc === "") {
        alertMessage += "Task Description cannot be empty. ";
    }
    if (task_deadline === "") {
        alertMessage += "Please select task deadline. ";
    }
    if (alertMessage !== ""){
        showMessage(alertMessage);
        return;
    }
    handleProgressBar();
}

function handleProgressBar() {
    $('#progressContainer').css('display', 'block');
    var progress = 0;
    var interval = setInterval(function() {
        progress += 10;
        $('#progressBar').css('width', progress + '%');
        if (progress >= 100) {
            clearInterval(interval);
            setTimeout(function() {
                $('#progressContainer').hide();
                $('#progressBar').css('width', '0%');
                sendFormData();
            }, 500);
        }
    }, 100);
}

function sendFormData() {
    var task_desc = $('#task_desc').val().trim();
    var task_deadline = $('#task_deadline').val().trim();
    var task_file = $('#task_file')[0].files[0];
    var formData = new FormData($('#uploadForm')[0]);

    formData.append('class_id', '<?php echo $class_id; ?>');
    <?php if (!empty($edit_task_id)) : ?>
    formData.append('edit_task_id', '<?php echo $edit_task_id; ?>');
    <?php endif; ?>

    formData.append('task_desc', task_desc);
    formData.append('task_deadline', task_deadline);
    formData.append('task_file', task_file);

    $.ajax({
        url: 'insert_task.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {
                $('#task_desc').val('');
                $('#task_deadline').val('');
                $('#task_file').val('');
                showMessage(jsonResponse.message); 
            } else {
                showMessage("An error occurred: " + jsonResponse.message); 
            }
        },
        error: function() {
            showMessage("An error occurred while processing your request.");
        }
    });
}

function showMessage(message) {
    $('#signup-message').text(message);
    setTimeout(function() {
        $('#signup-message').text('');
    }, 2500);
}
</script>
