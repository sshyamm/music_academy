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
        #responseMessageCourse {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageCourse">&nbsp;</h2>

    <div id="updateTableContainerCourse">
    <?php
    include("../db.php");
    $searchCourse = isset($_POST['searchCourse']) ? $_POST['searchCourse'] : '';
    $sql = "SELECT * FROM courses";
    if (!empty($searchCourse)) {
    	$sql .= " WHERE course_name LIKE '$searchCourse%'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Course Name</th><th>Course Description</th><th>Course Image</th><th>Course Icon</th><th>Course Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['course_id']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['course_desc']}</td>";
            echo "<td><img src='getForms/uploads/{$row['course_img']}' alt='Course Image'></td>";
            echo "<td><img src='getForms/uploads/{$row['course_icon']}' alt='Course Icon'></td>";
            echo "<td>{$row['course_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormCourse('edit_mode_course', {$row['course_id']})\">Edit</button>";
            echo "<button onclick=\"showFormCourse('delete_mode_course', {$row['course_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No courses found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerCourse"></div>

<button onclick="showFormCourse('create_mode_course', null)">Create Product</button>
</body>
</html>
