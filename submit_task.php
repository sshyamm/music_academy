<?php 
require_once 'includes/header.php';
require_once 'includes/config.php';

$task_id = isset($_GET['task_id']) ? $_GET['task_id'] : ''; 
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

$sql = "SELECT ct.task_desc, ct.task_deadline, cr.course_name, u.user_name, c.date_of_class
        FROM class_tasks ct
        JOIN classes c ON ct.date_parent_id = c.class_id
        JOIN courses cr ON ct.course_parent_id = cr.course_id
        JOIN users u ON c.user_parent_id = u.user_id
        WHERE ct.date_parent_id = :class_id";

$stmt = $db->prepare($sql);
$stmt->bindParam(':class_id', $class_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$task_desc = $result['task_desc'];
$course_name = $result['course_name'];
$user_name = $result['user_name'];
$date_of_class = $result['date_of_class'];
$task_deadline = $result['task_deadline'];
if ($task_deadline < date('Y-m-d')) {
    $deadline_badge = '<span class="badge bg-danger text-light">' . $task_deadline . '</span> (Overdue)';
} else {
    $deadline_badge = '<span class="badge bg-success text-light">' . $task_deadline . '</span>';
}
$sql_task_info = "SELECT * FROM tasks WHERE task_parent_id = :task_id AND user_parent_id = :user_id";

$stmt_task_info = $db->prepare($sql_task_info);
$stmt_task_info->bindParam(':task_id', $task_id);
$stmt_task_info->bindParam(':user_id', $user_id);
$stmt_task_info->execute();
$result_task_info = $stmt_task_info->fetch(PDO::FETCH_ASSOC);

$remark = $result_task_info['remark'];
$file_path = $result_task_info['file_path'];
$comment = $result_task_info['comment'];
$grading = $result_task_info['grading'];
$last_updated = $result_task_info['last_updated'];
$submit_status = '';

if (!empty($grading)) {
    $submit_status = 'Graded & Completed';
} elseif (!empty($remark) || !empty($file_path)) {
    $submit_status = 'Submitted For Review';
} else {
    $submit_status = 'Pending';
}

$sql_update_submit_status = "UPDATE tasks SET submit_status = :submit_status WHERE task_parent_id = :task_id AND user_parent_id = :user_id";
$stmt_update_submit_status = $db->prepare($sql_update_submit_status);
$stmt_update_submit_status->bindParam(':submit_status', $submit_status);
$stmt_update_submit_status->bindParam(':task_id', $task_id);
$stmt_update_submit_status->bindParam(':user_id', $user_id);
$stmt_update_submit_status->execute();
?>

<main class="custom-main">
    <div class="container mt-4">
        <h2 class="text-center mb-4">Task Details</h2>

        <div class="card mb-4 border-1 shadow-lg" style="border-radius: 40px;">
            <div class="card-header bg-warning text-dark rounded-top">
                Task Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="font-weight-bold"><?php echo $date_of_class; ?></h5>
                        <p><?php echo $course_name; ?> || <?php echo $user_name; ?></p>
                        <h5 class="font-weight-bold">Description</h5>
                        <p><?php echo $task_desc; ?></p>
                        <h5 class="font-weight-bold">Deadline</h5>
                        <h5><?php echo $deadline_badge; ?></h5>
                    </div>
                    <div class="col-md-6">
                        <h5 class="font-weight-bold">Comments by Teacher</h5>
                        <p><?php echo $comment; ?></p>
                        <h5 class="font-weight-bold">Grading by Teacher</h5>
                        <p><?php echo $grading; ?></p>
                        <h5 class="font-weight-bold">Last Updated</h5>
                        <p><?php echo $last_updated; ?></p>
                        <h5 class="font-weight-bold">Submission Status</h5>
                        <h5><span class="badge bg-success text-light"><?php echo $submit_status; ?></span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h2 id="signup-message">&nbsp;</h2>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="box-shadow: 0 0.8rem 3rem rgba(0, 0, 0, 0.2); border-radius: 1.5rem;">
                    <div class="card-header bg-warning text-dark">
                        Upload Task
                    </div>
                    <div class="card-body">
                        <form id="uploadForm" name="uploadForm" method="post" enctype="multipart/form-data" action="">
                            <div class="mb-3">
                                <label for="remark" class="form-label">Remarks</label>
                                <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="task_file" class="form-label">Task File</label>
                                <input class="form-control" type="file" id="file_path" name="file_path">
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
    <div class="container mt-5">
    <div class="card mb-4 border-1 rounded-lg shadow-lg" id="uploadedTasksContainer">
                <div class="card-header bg-warning text-black rounded-top">
                    Uploaded Submissions
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Remarks</th>
                                    <th>File Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $directory = "/opt/lampp/htdocs/music_academy/admin/getForms/uploads/";

                                if (is_dir($directory)) {
                                    $sql = "SELECT task_manager_id, remark, file_path FROM tasks WHERE task_parent_id = :task_id AND user_parent_id = :user_id";
                                    $stmt = $db->prepare($sql);
                                    $stmt->bindParam(':task_id', $task_id);
                                    $stmt->bindParam(':user_id', $user_id);
                                    $stmt->execute();
                                    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($tasks) {
                                        $count = 1;
                                        foreach ($tasks as $task) {
                                            echo "<tr>";
                                            echo "<td>" . $count . "</td>";
                                            echo "<td>" . $task['remark'] . "</td>";
                                            $file_path = $task['file_path'];
                                            echo "<td>";
                                            if ($file_path && file_exists($directory . $file_path)) {
                                                echo $file_path;
                                            } else {
                                                echo "No File Found";
                                            }
                                            echo "</td>";
                                            echo "<td>";
                                            if ($file_path && file_exists($directory . $file_path)) {
                                                echo "<a href='uploads/" . $file_path . "' download><button class='btn btn-primary btn-sm'>Download</button></a><span>&nbsp;</span>";
                                            }
                                            echo "<button class='btn btn-warning btn-sm edit-sb'>Edit Submission</button>";
                                            echo "<span>&nbsp;</span><button class='btn btn-danger btn-sm delete-sb'>Delete Submission</button>";
                                            echo "<td style='display: none;'><input type='hidden' class='task_manager_id' value='" . $task['task_manager_id'] . "'></td>";
                                            echo "</td>";
                                            echo "</tr>";
                                            $count++;
                                        }
                                    } else {
                                        echo "<tbody><tr><td colspan='4'><div class='alert alert-info text-center' role='alert'>No Submissions</div></td></tr></tbody>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No files found in the directory.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</main>
<?php require_once 'includes/footer.php'; ?>
<script>
$(document).ready(function() {
    var submissionExists = <?php echo ($submit_status === 'Submitted For Review' || $submit_status === 'Graded & Completed') ? 'true' : 'false'; ?>;

    if (submissionExists) {
        $('#upBtn').prop('disabled', true);
    }
    $('#upBtn').click(function() {
        handleFormData();
    });
    $('.delete-sb').click(function() {
        var taskManagerId = $(this).closest('tr').find('.task_manager_id').val();
        if (confirm('Are you sure you want to delete this submission?')) {
            deleteSubmission(taskManagerId);
        }
    });
    $('.edit-sb').click(function() {
        $('#upBtn').prop('disabled', false); 
        var remark = $(this).closest('tr').find('td:nth-child(2)').text().trim();
        $('#remark').val(remark);
        var taskManagerId = $(this).closest('tr').find('.task_manager_id').val();

        $('#upBtn').data('taskManagerId', taskManagerId);
        $('#upBtn').removeClass('btn-primary').addClass('btn-warning').text('Update');
    });
});
function deleteSubmission(taskManagerId) {
    $.ajax({
        url: 'delete_submission.php',
        type: 'POST',
        data: { task_manager_id: taskManagerId },
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {
                location.reload();
            } else {
                showMessage("An error occurred: " + jsonResponse.message);
            }
        },
        error: function() {
            showMessage("An error occurred while processing your request.");
        }
    });
}
function handleFormData() {
    var buttonLabel = $('#upBtn').text().trim();
    if (buttonLabel === 'Upload') {
        var remark = $('#remark').val().trim();
        if (remark === '') {
            showMessage('Remark cannot be empty.');
            return;
        }
        handleProgressBar(sendFormData); 
    } else if (buttonLabel === 'Update') {
        var remark = $('#remark').val().trim();
        if (remark === '') {
            showMessage('Remark cannot be empty.');
            return;
        }
        var taskManagerId = $('#upBtn').data('taskManagerId');
        handleProgressBar(function() {
            updateSubmission(taskManagerId); 
        });
    }
}

function handleProgressBar(callback) {
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
                if (callback) {
                    callback(); 
                }
            }, 500);
        }
    }, 100);
}
function updateSubmission(taskManagerId) {
    var remark = $('#remark').val().trim();
    var file_path = $('#file_path')[0].files[0];

    var formData = new FormData($('#uploadForm')[0]);
    formData.append('remark', remark);
    formData.append('file_path', file_path);
    formData.append('task_manager_id', taskManagerId); 

    $.ajax({
        url: 'edit_submission.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {
                $('#remark').val('');
                $('#file_path').val('');
                $('#upBtn').removeClass('btn-warning').addClass('btn-primary').text('Upload');
                showMessage(jsonResponse.message);
                location.reload(); 
            } else {
                showMessage("An error occurred: " + jsonResponse.message);
            }
        },
        error: function() {
            showMessage("An error occurred while processing your request.");
        }
    });
}
function sendFormData() {
    var remark = $('#remark').val().trim();
    var file_path = $('#file_path')[0].files[0];
    var task_id = <?php echo $task_id; ?>; 
    var user_id = "<?php echo $user_id; ?>";

    var formData = new FormData($('#uploadForm')[0]);
    formData.append('remark', remark);
    formData.append('file_path', file_path);
    formData.append('task_id', task_id); 
    formData.append('user_id', user_id); 

    $.ajax({
        url: 'upload_task.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.success) {
                $('#remark').val('');
                $('#file_path').val('');
                showMessage(jsonResponse.message);
                location.reload(); 
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
