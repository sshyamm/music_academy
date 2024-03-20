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
        #responseMessageInterest {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageInterest">&nbsp;</h2>

<div id="updateTableContainerInterest">
<?php
include("../db.php");
$sql = "SELECT i.*, 
           us.user_name,
           cl.date_of_class,
           c.course_name, 
           l.level_name
    FROM interests i
    LEFT JOIN users us ON i.user_parent_id = us.user_id
    LEFT JOIN classes cl ON i.interest_date = cl.class_id
    LEFT JOIN courses c ON i.course_parent_id = c.course_id
    LEFT JOIN levels l ON i.level_parent_id = l.level_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Student Name</th><th>Course Name</th><th>Level Name</th><th>Interest Date</th><th>Interest Status</th><th>Action</th></tr>"; 
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['interest_id']}</td>";
        echo "<td>{$row['user_name']}</td>";
        echo "<td>{$row['course_name']}</td>";
        echo "<td>{$row['level_name']}</td>";
        echo "<td>{$row['date_of_class']}</td>";
        echo "<td>{$row['interest_status']}</td>";
        echo "<td>";
        echo "<button onclick=\"showFormInterest('edit_mode_int', {$row['interest_id']})\">Edit</button>";
        echo "<button onclick=\"showFormInterest('delete_mode_int', {$row['interest_id']})\">Delete</button>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No Interests found."; 
}

$conn->close();
?>
</div>
<div id="formContainerInterest"></div>

<button onclick="showFormInterest('create_mode_int', null)">Create Interest</button>

</body>
</html>
