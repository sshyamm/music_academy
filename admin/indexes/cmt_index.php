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
        #responseMessagePhase {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageCmt">&nbsp;</h2>

<div id="updateTableContainerCmt">
    <?php
    include("../db.php");
    $sql = "SELECT Ct.*, 
               u.user_name,
	       c.course_name
        FROM comments Ct
        LEFT JOIN courses c ON Ct.course_parent_id = c.course_id
	LEFT JOIN users u ON Ct.user_parent_id = u.user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>User Name</th><th>Comment</th><th>Course Name</th><th>Created At</th><th>Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['comment_id']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['comment']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['comment_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormCmt('edit_mode_cmt', {$row['comment_id']})\">Edit</button>";
            echo "<button onclick=\"showFormCmt('delete_mode_cmt', {$row['comment_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No comments found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerCmt"></div>

<button onclick="showFormCmt('create_mode_cmt', null)">Create Comment</button>

</body>
</html>
