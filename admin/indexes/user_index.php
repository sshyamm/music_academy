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
        #responseMessageLevel {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageUser">&nbsp;</h2>

    <div id="updateTableContainerUser">
    <?php
    include("../db.php");
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>User Name</th><th>User Type</th><th>User Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['user_id']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['user_type']}</td>";
            echo "<td>{$row['user_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormUser('edit_mode_user', {$row['user_id']})\">Edit</button>";
            echo "<button onclick=\"showFormUser('delete_mode_user', {$row['user_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No Users found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerUser"></div>

<button onclick="showFormUser('create_mode_user', null)">Create User</button>
</body>
</html>
