<?php require_once 'includes/header.php'; ?>

<main class="custom-main">
    <div class="lux-styled-section" style="font-family: 'didact-gothic';">
        <div class="container mt-5">
            <h2 class="text-center text-dark mb-4">Classes Information</h2>
            <div class="text-center mb-4">
                <button class="btn btn-primary add-class-btn">Add Class</button>
            </div>

            <?php
            require_once 'includes/config.php';

            $sql = "SELECT ti.*, 
                           c.course_name,
                           t.teacher_username
                    FROM classes ti
                    LEFT JOIN courses c ON ti.course_parent_id = c.course_id
                    LEFT JOIN teachers t ON ti.teacher_parent_id = t.teacher_id";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                echo "<div class='table-responsive'>";
                echo "<table class='table'>";
                echo "<thead class='thead-dark'>";
                echo "<tr>";
                echo "<th>Course</th>";
                echo "<th>Teacher</th>";
                echo "<th>Start Time</th>";
                echo "<th>End Time</th>";
                echo "<th>Date</th>";
                echo "<th>Class Status</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($data as $row) {
                    echo "<tr>";
                    echo "<td class='font-weight-bold'>" . $row['course_name'] . "</td>";
                    echo "<td class='font-weight-bold'>" . $row['teacher_username'] . "</td>";
                    echo "<td>" . $row['start_time'] . "</td>";
                    echo "<td>" . $row['end_time'] . "</td>";
                    echo "<td>" . $row['date_of_class'] . "</td>";
                    echo "<td>" . $row['class_status'] . "</td>";
                    echo "<td><a href='class_details.php?id=" . $row['class_id'] . "' class='btn btn-secondary view-students-btn'>View Details</a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "No class found.";
            }
            ?>

        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
