<?php
    include("../db.php");

    $sql = "SELECT s.*, us.user_name, ag.age_group_name, c.course_name, l.level_name, ci.city_name, st.state_name, co.country_name
            FROM students s
            LEFT JOIN users us ON s.user_parent_id = us.user_id
            LEFT JOIN age_groups ag ON s.age_group_parent_id = ag.age_group_id
            LEFT JOIN courses c ON s.course_parent_id = c.course_id
            LEFT JOIN levels l ON s.level_parent_id = l.level_id
            LEFT JOIN cities ci ON s.city_parent_id = ci.city_id
            LEFT JOIN states st ON s.state_parent_id = st.state_id
            LEFT JOIN countries co ON s.country_parent_id = co.country_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Student Username</th><th>Phone Number</th><th>Email</th><th>Age Group</th><th>Course</th><th>Level</th><th>Emergency Contact</th><th>Blood Group</th><th>Address</th><th>Pincode</th><th>City</th><th>State</th><th>Country</th><th>Student Status</th><th>Joined Date</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['student_id']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['phone_num']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['age_group_name']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['level_name']}</td>";
            echo "<td>{$row['emergency_contact']}</td>";
            echo "<td>{$row['blood_group']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['pincode']}</td>";
            echo "<td>{$row['city_name']}</td>";
            echo "<td>{$row['state_name']}</td>";
            echo "<td>{$row['country_name']}</td>";
            echo "<td>{$row['student_status']}</td>";
            echo "<td>{$row['joined_date']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormStudent('edit_mode_student', {$row['student_id']})\">Edit</button>";
            echo "<button onclick=\"showFormStudent('delete_mode_student', {$row['student_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No students found."; 
    }
    $conn->close();
    ?>