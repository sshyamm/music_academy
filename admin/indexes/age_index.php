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

        #responseMessageAge {
            height: 20px;
        }

        #updateTableContainerAge {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2 id="responseMessageAge">&nbsp;</h2>

    <div id="updateTableContainerAge">
    <?php
    include("../db.php");
    $sql = "SELECT * FROM age_groups";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Age group</th><th>Age group status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['age_group_id']}</td>";
            echo "<td>{$row['age_group_name']}</td>";
            echo "<td>{$row['age_group_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormAge('edit_mode_age', {$row['age_group_id']})\">Edit</button>";
            echo "<button onclick=\"showFormAge('delete_mode_age', {$row['age_group_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No ages found."; 
    }

    $conn->close();
    ?>
    </div>
    <div id="formContainerAge"></div>

    <button onclick="showFormAge('create_mode_age', null)">Create Age</button>
</body>
</html>
