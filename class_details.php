<?php
require_once 'includes/header.php';
require_once 'includes/config.php';

if (!isset($_SESSION['user_type'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

$sql = "SELECT ti.*, 
        c.course_name,
        c.course_desc,
        us.user_name AS teacher_name,
        cr.class_room_id,
        cr.user_parent_id AS student_id,
        stu.user_name AS student_name,
        s.email AS student_email,
        cr.attendance AS attendance_status
    FROM classes ti
    LEFT JOIN courses c ON ti.course_parent_id = c.course_id
    LEFT JOIN users us ON ti.user_parent_id = us.user_id
    LEFT JOIN class_rooms cr ON ti.class_id = cr.class_parent_id
    LEFT JOIN users stu ON cr.user_parent_id = stu.user_id
    LEFT JOIN students s ON stu.user_id = s.user_parent_id
    WHERE ti.class_id = :class_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':class_id', $class_id);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($data) {
        $row = $data[0];

        $course_name = $row['course_name'];
        $course_desc = $row['course_desc'];
        $teacher_name = $row['teacher_name'];
        $sched_start_time = $row['sched_start_time'];
        $sched_end_time = $row['sched_end_time'];
        $date_of_class = $row['date_of_class'];
        $class_status = $row['class_status'];
        $actual_start_time = $row['actual_start_time'];
        $actual_end_time = $row['actual_end_time'];

        $students = [];

        foreach ($data as $student) {
            if (!is_null($student['student_name']) && !is_null($student['student_email']) && !is_null($student['class_room_id'])) {
                $students[] = [
                    'name' => $student['student_name'],
                    'email' => $student['student_email'],
                    'class_room_id' => $student['class_room_id'],
                    'attendance_status' => $student['attendance_status']
                ];
            }
        }
    } else {
        $students = [];
        echo "No class found for the provided ID.";
        exit();
    }
} else {
    echo "Class ID is not provided.";
    exit();
}
$startButtonVisible = false;
$endButtonVisible = false;
$attendanceVisible = false; 
if (!is_null($actual_start_time)) {
    $attendanceVisible = true;
}

if (is_null($row['actual_start_time']) && is_null($row['actual_end_time'])) {
    $startButtonVisible = true;
    $attendanceVisible = false;
} elseif (is_null($row['actual_end_time'])) {
    $endButtonVisible = true;
    $attendanceVisible = true;

}
$disableDropdowns = !is_null($actual_start_time) && !is_null($actual_end_time);
?>
<main class="custom-main">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Class Details</h2>

        <div class="card mb-4 border-1 shadow-lg" style="border-radius: 40px;">
            <div class="card-header bg-warning text-dark rounded-top">
                Class Information
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Course:</strong> <?php echo $course_name; ?></p>
                        <p><strong>Teacher:</strong> <?php echo $teacher_name; ?></p>
                        <p><strong>Start Time:</strong> <?php echo $sched_start_time; ?></p>
                        <p><strong>End Time:</strong> <?php echo $sched_end_time; ?></p>
                        <p><strong>Date:</strong> <?php echo $date_of_class; ?></p>
                        <p><strong>Class Status:</strong> <span class="badge badge-success"><?php echo $class_status; ?></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Description:</strong> <?php echo $course_desc; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 border-1 rounded-lg shadow-lg">
            <div class="card-header bg-warning text-black rounded-top">
                Students List
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <?php if($_SESSION['user_type'] == 'Teacher'){ ?>
                                    <th id="attendance-heading" style="display: none;">Attendance</th>
                                    <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                    <?php if (!empty($students)) { ?>
                        <tbody>
                        <?php
                            $count = 1;
                            foreach ($students as $student) {
                                echo "<tr>";
                                echo "<td>" . $count . "</td>";
                                echo "<td>" . $student['name'] . "</td>";
                                echo "<td>" . $student['email'] . "</td>";
                                if ($_SESSION['user_type'] === 'Teacher') {
                                    $attendanceStatus = $student['attendance_status'];

                                    if (!is_null($attendanceStatus)) {
                                        echo "<td class=\"attendance-column\"";
                                        if (!$attendanceVisible) echo " style=\"display: none;\"";
                                        echo ">" . $attendanceStatus . "<span>&nbsp;</span><span class='text-success'><i class='bi bi-check-circle-fill'></i></span></td>";
                                    } else {
                                        echo "<td class=\"attendance-column\"";
                                        if (!$attendanceVisible) echo " style=\"display: none;\"";
                                        echo ">
                                            <select class='form-control attendance-dropdown'>
                                                <option value='Select'>Select</option>
                                                <option value='Present'>Present</option>
                                                <option value='Absent'>Absent</option>
                                                <option value='Late'>Late</option>
                                            </select>
                                        </td>";
                                    }

                                    echo "<td>
                                        <button class='btn btn-danger btn-sm delete-btn'>Delete</button>
                                    </td>";
                                    echo "<td style='display: none;'><input type='hidden' class='class_room_id' value='" . $student['class_room_id'] . "'></td>";
                                }    
                                echo "</tr>";
                                $count++;
                            }
                        ?>
                        </tbody>
                    <?php } else { ?>
                        <tbody>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-info text-center" role="alert">
                                        No students added
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                    </table>
                </div>
            </div>
        </div>


            <?php if($_SESSION['user_type'] == 'Teacher'): ?>
                <div class="text-center">
                <?php if ($startButtonVisible): ?>
                    <button class="btn btn-warning start-class-btn mr-2">Start Class</button>
                <?php elseif ($endButtonVisible): ?>
                    <button class="btn btn-danger end-class-btn mr-2">End Class</button>
                <?php endif; ?>
                <a href="file_upload.php?class_id=<?php echo $class_id; ?>" class="btn btn-primary mr-2">Upload Task</a>
                <a href="add_student.php?class_id=<?php echo $class_id; ?>" class="btn btn-secondary">Add Students</a>
            </div>
                <span>&nbsp;</span>
            <?php endif; ?>

            <div class="card mb-4 border-1 rounded-lg shadow-lg" id="uploadedTasksContainer">
                <div class="card-header bg-warning text-black rounded-top">
                    Uploaded Tasks
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Task Description</th>
                                    <th>File Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $directory = "/opt/lampp/htdocs/music_academy/admin/getForms/uploads/";

                                if (is_dir($directory)) {
                                    $course_parent_id = $row['course_parent_id'];
                                    $sql = "SELECT task_id, task_desc, task_file FROM class_tasks WHERE date_parent_id = :class_id AND course_parent_id = :course_id";
                                    $stmt = $db->prepare($sql);
                                    $stmt->bindParam(':class_id', $class_id);
                                    $stmt->bindParam(':course_id', $course_parent_id);
                                    $stmt->execute();
                                    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if ($tasks) {
                                        $count = 1;
                                        foreach ($tasks as $task) {
                                            echo "<tr>";
                                            echo "<td>" . $count . "</td>";
                                            echo "<td>" . $task['task_desc'] . "</td>";
                                            $task_file = $task['task_file'];
                                            echo "<td>";
                                            if ($task_file && file_exists($directory . $task_file)) {
                                                echo $task_file;
                                            } else {
                                                echo "No File Found";
                                            }
                                            echo "</td>";
                                            echo "<td>";
                                            if ($task_file && file_exists($directory . $task_file)) {
                                                echo "<a href='uploads/" . $task_file . "' download><button class='btn btn-primary btn-sm'>Download</button></a><span>&nbsp;</span>";
                                            }
                                            if ($_SESSION['user_type'] == 'Teacher') {
                                                echo "<button class='btn btn-warning btn-sm edit-tsk'>Edit Task</button>";
                                                echo "<span>&nbsp;</span><button class='btn btn-danger btn-sm delete-tsk'>Delete Task</button>";
                                                echo "<td style='display: none;'><input type='hidden' class='task_id' value='" . $task['task_id'] . "'></td>";
                                            }
                                            echo "</td>";
                                            echo "</tr>";
                                            $count++;
                                        }
                                    } else {
                                        echo "<tbody><tr><td colspan='4'><div class='alert alert-info text-center' role='alert'>No Tasks Assigned</div></td></tr></tbody>";
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
            <div class="card mb-4 border-1 rounded-lg shadow-lg">
                <div class="card-header bg-warning text-black rounded-top">
                    Leave a Comment
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea class="form-control" id="comment" rows="3" placeholder="Enter your comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>

                    <div class="mt-4">
                    <h3>Comments</h3>
                    <span>&nbsp;</span>
                        <p><strong>John Doe</strong> - March 12, 2024</p>
                        <p>This is a sample comment.</p>
                        <hr>
                        <p><strong>Jane Smith</strong> - March 11, 2024</p>
                        <p>Another sample comment here.</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>
    <span>&nbsp;</span>
    <script>
        $(document).ready(function() {
                $(".start-class-btn, .end-class-btn").click(function() {
                var classId = <?php echo $class_id; ?>;
                var action = $(this).hasClass("start-class-btn") ? "start" : "end";

                $.ajax({
                    url: 'update_class_status.php',
                    method: 'POST',
                    data: { class_id: classId, action: action },
                    success: function(response) {
                        if (action === "start") {
                            $(".start-class-btn").text("End Class").removeClass("btn-warning").addClass("btn-danger").removeClass("start-class-btn").addClass("end-class-btn");
                            $("#attendance-heading").show(); 
                            $(".attendance-column").show();
                        } else {
                            $(".end-class-btn").hide();
                            $(".attendance-column select").prop('disabled', true);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error updating class status: " + error);
                    }
                });
            });
            $(".edit-tsk").click(function() {
                var taskId = $(this).closest("tr").find(".task_id").val();
                window.location.href = "file_upload.php?class_id=<?php echo $class_id; ?>&edit_task_id=" + taskId;
            });
                <?php if ($attendanceVisible): ?>
                $("#attendance-heading").show();
                <?php endif; ?>
            $("select.attendance-dropdown").change(function() {
                var attendance = $(this).val(); 
                var classRoomId = $(this).closest("tr").find(".class_room_id").val(); 
                var tickSymbol = '<span>&nbsp;</span><span class="text-success"><i class="bi bi-check-circle-fill"></i></span>';
                var selectedText = $(this).find('option:selected').text() + " " + tickSymbol;
                var selectedSpan = $('<span>').html(selectedText);

                $(this).replaceWith(selectedSpan);

                $.ajax({
                    url: 'update_attendance.php',
                    method: 'POST',
                    data: { class_room_id: classRoomId, attendance: attendance },
                    success: function(response) {
                    },
                    error: function(xhr, status, error) {
                        console.error("Error updating attendance: " + error);
                    }
                });
            });
            <?php if ($disableDropdowns): ?>
                $(".attendance-column select").prop('disabled', true);
            <?php endif; ?>
            $(".delete-btn").click(function() {
                var classRoomId = $(this).closest("tr").find(".class_room_id").val();
                var confirmation = confirm("Are you sure you want to delete this student?");
                if (confirmation) {
                    $.ajax({
                        url: 'delete_student.php',
                        method: 'POST',
                        data: { class_room_id: classRoomId },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert("Error deleting student: " + error);
                        }
                    });
                }
            });

            $(".delete-tsk").click(function() {
                var taskId = $(this).closest("tr").find(".task_id").val();
                var confirmation = confirm("Are you sure you want to delete this task?");
                if (confirmation) {
                    $.ajax({
                        url: 'delete_task.php',
                        method: 'POST',
                        data: { task_id: taskId },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert("Error deleting task: " + error);
                        }
                    });
                }
            });
        });
    </script>
<?php require_once 'includes/footer.php'; ?>
