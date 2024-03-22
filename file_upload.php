<?php 
require_once 'includes/header.php';
require_once 'includes/config.php';

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : ''; 
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<main class="custom-main">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
            <div class="card" style="box-shadow: 0 0.8rem 3rem rgba(0, 0, 0, 0.4); border-radius: 1.5rem;">
                <div class="card-header bg-warning text-dark">
                Upload Task
                </div>
                <div class="card-body">
                <form id="uploadForm" name="uploadForm" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                    <label for="task_desc" class="form-label">Task Description</label>
                    <textarea class="form-control" id="task_desc" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                    <label for="task_file" class="form-label">Task File</label>
                    <input class="form-control" type="file" id="task_file">
                    </div>
                    <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="upBtn">Upload</button><span>&nbsp;</span>
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
    if (task_desc === '') {
        alert('Task description cannot be empty.');
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
    var task_file = $('#task_file')[0].files[0];
    var formData = new FormData($('#uploadForm')[0]);

    formData.append('class_id', '<?php echo $class_id; ?>');

    formData.append('task_desc', task_desc);
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
                $('#task_file').val('');
                alert(jsonResponse.message);
            } else {
                alert("An error occurred: " + jsonResponse.message);
            }
        },
        error: function() {
            alert("An error occurred while processing your request.");
        }
    });
}
</script>
