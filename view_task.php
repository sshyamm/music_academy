<?php
require_once 'includes/header.php';
require_once 'includes/config.php';

if (isset($_GET['task_id']) && isset($_GET['class_id'])) {
    $task_id = $_GET['task_id'];
    $class_id = $_GET['class_id'];
?>
    <main class="custom-main">
        <div class="container mt-5">
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
                                    <th>Student Name</th>
                                    <th>File Name</th>
                                    <th>Remark</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $directory = "/var/www/html/music_academy/admin/getForms/uploads/";

                            $sql_class_rooms = "SELECT cr.user_parent_id, u.user_name
                                                FROM class_rooms cr
                                                LEFT JOIN users u ON cr.user_parent_id = u.user_id
                                                WHERE cr.class_parent_id = :class_id";
                            $stmt_class_rooms = $db->prepare($sql_class_rooms);
                            $stmt_class_rooms->bindParam(':class_id', $class_id);
                            $stmt_class_rooms->execute();
                            $class_room_users = $stmt_class_rooms->fetchAll(PDO::FETCH_ASSOC);

                            if ($class_room_users) {
                                $count = 1;
                                foreach ($class_room_users as $user) {
                                    $user_parent_id = $user['user_parent_id'];
                                    $user_name = $user['user_name'];

                                    $sql_tasks = "SELECT task_manager_id, file_path, remark, submit_status
                                                FROM tasks
                                                WHERE task_parent_id = :task_id
                                                AND user_parent_id = :user_parent_id";
                                    $stmt_tasks = $db->prepare($sql_tasks);
                                    $stmt_tasks->bindParam(':task_id', $task_id);
                                    $stmt_tasks->bindParam(':user_parent_id', $user_parent_id);
                                    $stmt_tasks->execute();
                                    $task_details = $stmt_tasks->fetch(PDO::FETCH_ASSOC);

                                    echo "<tr>";
                                    echo "<td>" . $count . "</td>";
                                    echo "<td>" . $user_name . "</td>";
                                    if ($task_details) {
                                        echo "<td>";
                                        if ($task_details['file_path'] && file_exists($directory . $task_details['file_path'])) {
                                            echo $task_details['file_path'];
                                        } else {
                                            echo "No File Submitted";
                                        }
                                        echo "</td>";
                                        echo "<td>" . ($task_details['remark'] ?: 'N/A') . "</td>";
                                        echo "<td>" . ($task_details['submit_status'] ?: 'Not Submitted') . "</td>";
                                        echo "<td>";
                                        if ($task_details['file_path'] && file_exists($directory . $task_details['file_path'])) {
                                            echo "<a href='/music_academy/admin/getForms/uploads/" . $task_details['file_path'] . "' download><button class='btn btn-primary btn-sm'>Download</button></a><span>&nbsp;</span>";
                                        }
                                        echo "<span>&nbsp;</span><a href='evaluate.php?task_manager_id=" . $task_details['task_manager_id'] . "' class='btn btn-success btn-sm evl-btn'>Evaluate</a>";
                                        echo "</td>";
                                    } else {
                                        echo "<td colspan='5'>No Task Submitted</td>";
                                    }
                                    echo "</tr>";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='6'><div class='alert alert-info text-center' role='alert'>No Students Found or No Tasks Assigned</div></td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
} else {
    echo "<p>Task ID or Class ID is not provided.</p>";
}

require_once 'includes/footer.php';
?>
