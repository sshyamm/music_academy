<?php require_once 'includes/header.php'; ?>
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
                            <p><strong>Course:</strong> Course Name</p>
                            <p><strong>Teacher:</strong> Teacher Name</p>
                            <p><strong>Start Time:</strong> 10:00 AM</p>
                            <p><strong>End Time:</strong> 11:30 AM</p>
                            <p><strong>Date:</strong> March 12, 2024</p>
                            <p><strong>Class Status:</strong> <span class="badge badge-success">Active</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Description:</strong> Explore the world of music in our dynamic and engaging music classes. Whether you're a beginner or an experienced musician, our classes offer something for everyone. Learn to play your favorite instruments, delve into music theory, and discover the joy of creating music with others. Our experienced instructors provide personalized guidance to help you develop your skills and reach your musical goals. Join us and embark on a musical journey filled with creativity, expression, and camaraderie.</p>
                        
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
