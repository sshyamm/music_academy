<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #000;
            padding: 10px;
        }

        th {
            background-color: #000;
            color: #fff;
        }

        button {
            padding: 10px;
            font-size: 16px;
            margin: 10px;
        }
        #responseMessageClass {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageClass">&nbsp;</h2>

<div id="updateTableContainerClass">
    <?php
    include("../db.php");
    $searchCourse = isset($_POST['searchCourse']) ? $_POST['searchCourse'] : '';
    $searchTeacher = isset($_POST['searchTeacher']) ? $_POST['searchTeacher'] : '';
    $sql = "SELECT ti.*, 
               c.course_name,
	       us.user_name
        FROM classes ti
        LEFT JOIN courses c ON ti.course_parent_id = c.course_id
	LEFT JOIN users us ON ti.user_parent_id = us.user_id";

if (!empty($searchCourse) && !empty($searchTeacher)) {
    $sql .= " WHERE course_name LIKE '$searchCourse%' AND teacher_username LIKE '$searchTeacher%'";
} elseif (!empty($searchCourse)) {
    $sql .= " WHERE course_name LIKE '$searchCourse%'";
} elseif (!empty($searchName)) {
    $sql .= " WHERE teacher_username LIKE '$searchTeacher%'";
}
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Course</th><th>Teacher</th><th>Start Time</th><th>End Time</th><th>Date</th><th>Created At</th><th>Updated At</th><th>Class Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['class_id']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['sched_start_time']}</td>";
            echo "<td>{$row['sched_end_time']}</td>";
            echo "<td>{$row['date_of_class']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['updated_at']}</td>";
            echo "<td>{$row['class_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormClass('edit_mode_class', {$row['class_id']})\">Edit</button>";
            echo "<button onclick=\"showFormClass('delete_mode_class', {$row['class_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No class found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerClass"></div>

<button onclick="showFormClass('create_mode_class', null)">Create Slot</button>

</body>
</html>
