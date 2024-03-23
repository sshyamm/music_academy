<?php require_once 'includes/header.php'; ?>

<main class="custom-main">
    <div class="lux-styled-section" style="font-family: 'didact-gothic';">
        <div class="container mt-5">
            <h2 class="text-center text-dark mb-4">Classes Information</h2>

            <?php
            require_once 'includes/config.php';

            $user_name = $_SESSION['user_name'] ?? '';
            $user_type = $_SESSION['user_type'] ?? '';

            $sql = "SELECT ti.*, 
                           c.course_name,
                           us.user_name
                    FROM classes ti
                    LEFT JOIN courses c ON ti.course_parent_id = c.course_id
                    LEFT JOIN users us ON ti.user_parent_id = us.user_id";

            if ($user_type == 'Student') {
                $sql .= " WHERE ti.class_id IN (
                            SELECT cr.class_parent_id
                            FROM class_rooms cr
                            WHERE cr.user_parent_id = (
                                SELECT user_id
                                FROM users
                                WHERE user_name = :user_name
                            )
                        )";
            } else {
                $sql .= " WHERE us.user_name = :user_name";
            }

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':user_name', $user_name);
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
                    echo "<td class='font-weight-bold'>" . $row['user_name'] . "</td>";
                    echo "<td>" . $row['sched_start_time'] . "</td>";
                    echo "<td>" . $row['sched_end_time'] . "</td>";
                    echo "<td>" . $row['date_of_class'] . "</td>";
                    echo "<td>" . $row['class_status'] . "</td>";
                    echo "<td><a href='class_details.php?class_id=" . $row['class_id'] . "' class='btn btn-secondary view-students-btn'>View Details</a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "No class found for the current user.";
            }
            ?>

        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
