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
<h2 id="responseMessageLevel">&nbsp;</h2>

    <div id="updateTableContainerLevel">
    <?php
    include("../db.php");
    $searchLevel = isset($_POST['searchLevel']) ? $_POST['searchLevel'] : '';
    $sql = "SELECT * FROM levels";
    if (!empty($searchLevel)) {
    	$sql .= " WHERE level_name LIKE '$searchLevel%'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Level Name</th><th>Level Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['level_id']}</td>";
            echo "<td>{$row['level_name']}</td>";
            echo "<td>{$row['level_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormLevel('edit_mode_level', {$row['level_id']})\">Edit</button>";
            echo "<button onclick=\"showFormLevel('delete_mode_level', {$row['level_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No Levels found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerLevel"></div>

<button onclick="showFormLevel('create_mode_level', null)">Create Level</button>
</body>
</html>
