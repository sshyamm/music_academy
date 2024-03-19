<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    require_once 'includes/header.php';
    require_once 'includes/config.php';

    if(isset($_GET['class_id'])) {
        $class_id = $_GET['class_id'];

        $sql = "SELECT ti.*, 
                       c.course_name,
                       c.course_desc,
                       us.user_name
                FROM classes ti
                LEFT JOIN courses c ON ti.course_parent_id = c.course_id
                LEFT JOIN users us ON ti.user_parent_id = us.user_id
                WHERE ti.class_id = :class_id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':class_id', $class_id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($data) {
            $row = $data[0];

            $course_name = $row['course_name'];
            $course_desc = $row['course_desc'];
            $teacher_name = $row['user_name'];
            $start_time = $row['start_time'];
            $end_time = $row['end_time'];
            $date_of_class = $row['date_of_class'];
            $class_status = $row['class_status'];
        } else {
            echo "No class found for the provided ID.";
            exit(); 
        }
    } else {
        echo "Class ID is not provided.";
        exit(); 
    }
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
                        <p><strong>Start Time:</strong> <?php echo $start_time; ?></p>
                        <p><strong>End Time:</strong> <?php echo $end_time; ?></p>
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
                                    <th>Attendance</th> 
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Student 1</td>
                                    <td>student1@example.com</td>
                                    <td>
                                        <select class="form-control">
                                            <option value="On Time">On Time</option>
                                            <option value="Delayed">Delayed</option>
                                            <option value="Absent">Absent</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button class="btn btn-warning mr-2">Start Class</button>
                <a href="file_upload.php" class="btn btn-primary mr-2">Upload Task</a>
                <button class="btn btn-secondary">Add Student</button>
            </div>
            <span>&nbsp;</span>

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
                                    <th>File Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $directory = "uploads/";

                                    if (is_dir($directory)) {
                                        $files = scandir($directory);

                                        $count = 1;

                                        foreach ($files as $file) {
                                            if ($file != "." && $file != "..") {
                                                echo "<tr>";
                                                echo "<td>" . $count . "</td>";
                                                echo "<td>" . $file . "</td>";
                                                echo "<td><a href='uploads/" . $file . "' download><button class='btn btn-primary btn-sm'>Download</button></a> <button class='btn btn-danger btn-sm delete-btn'>Delete</button></td>";
                                                echo "</tr>";
                                                $count++;
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No files found in the directory.</td></tr>";
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
    <?php require_once 'includes/footer.php'; ?>
