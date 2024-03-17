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
        #responseMessageTeacher {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageTeacher">&nbsp;</h2>

    <div id="updateTableContainerTeacher">
    <?php
    include("../db.php");
    $searchName = isset($_POST['searchName']) ? $_POST['searchName'] : '';
    $sql = "SELECT s.*,
               us.user_name,  
               c.course_name
        FROM teachers s
        LEFT JOIN courses c ON s.course_parent_id = c.course_id
        LEFT JOIN users us ON s.user_parent_id = us.user_id";
    if (!empty($searchName)) {
    	$sql .= " WHERE us.user_name LIKE '$searchName%'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Teacher Name</th><th>Teacher Phone</th><th>Teacher Email</th><th>Teacher Address</th><th>Specialize</th><th>Qualification</th><th>Experience</th><th>Contract Date</th><th>Current Salary</th><th>Joined Date</th><th>Teacher Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['teacher_id']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['teacher_phone']}</td>";
            echo "<td>{$row['teacher_email']}</td>";
            echo "<td>{$row['teacher_address']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['qualification']}</td>";
            echo "<td>{$row['teacher_exp']}</td>";
            echo "<td>{$row['contract_date']}</td>";
            echo "<td>{$row['current_salary']}</td>";
            echo "<td>{$row['join_date']}</td>";
            echo "<td>{$row['teacher_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormTeacher('edit_mode_teacher', {$row['teacher_id']})\">Edit</button>";
            echo "<button onclick=\"showFormTeacher('delete_mode_teacher', {$row['teacher_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No Teachers found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerTeacher"></div>

<button onclick="showFormTeacher('create_mode_teacher', null)">Create Teacher</button>
</body>
</html>
