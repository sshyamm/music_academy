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
        #responseMessageTask {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageTask">&nbsp;</h2>

<div id="updateTableContainerTask">
    <?php
    include("../db.php");
    $searchName = isset($_POST['searchName']) ? $_POST['searchName'] : '';
    $sql = "SELECT t.*, 
    u.user_name AS assigned_to_name,
    te.user_name AS assigned_by_name
    FROM tasks t
    LEFT JOIN users u ON t.assigned_to = u.user_id
    LEFT JOIN users te ON t.assigned_by = te.user_id";

    if (!empty($searchName)) {
    	$sql .= " WHERE task_title LIKE '$searchName%'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Task title</th><th>Task Description</th><th>Assigned To</th><th>Assigned By</th><th>Deadline</th><th>Priority</th><th>Created At</th><th>Updated At</th><th>Estimated Hours</th><th>File Path</th><th>Task Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['task_id']}</td>";
            echo "<td>{$row['task_title']}</td>";
            echo "<td>{$row['task_desc']}</td>";
            echo "<td>{$row['assigned_to_name']}</td>";
            echo "<td>{$row['assigned_by_name']}</td>";
            echo "<td>{$row['deadline']}</td>";
            echo "<td>{$row['priority']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['updated_at']}</td>";
            echo "<td>{$row['estimated_hours']}</td>";
            echo "<td>{$row['file_path']}</td>";
            echo "<td>{$row['task_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormTask('edit_mode_task', {$row['task_id']})\">Edit</button>";
            echo "<button onclick=\"showFormTask('delete_mode_task', {$row['task_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No tasks found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerTask"></div>

<button onclick="showFormTask('create_mode_task', null)">Create Task</button>

</body>
</html>
