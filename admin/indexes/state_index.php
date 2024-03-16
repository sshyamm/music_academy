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
        #responseMessageCity {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageState">&nbsp;</h2>

    <div id="updateTableContainerState">
    <?php
    include("../db.php");
    $searchState = isset($_POST['searchState']) ? $_POST['searchState'] : '';
    $sql = "SELECT s.*, 
               co.country_name
        FROM states s
        LEFT JOIN countries co ON s.country_parent_id = co.country_id";
    if (!empty($searchState)) {
    	$sql .= " WHERE state_name LIKE '$searchState%'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Country</th><th>State Name</th><th>State Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['state_id']}</td>";
            echo "<td>{$row['country_name']}</td>";
            echo "<td>{$row['state_name']}</td>";
            echo "<td>{$row['state_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormState('edit_mode_state', {$row['state_id']})\">Edit</button>";
            echo "<button onclick=\"showFormState('delete_mode_state', {$row['state_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No states found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerState"></div>

<button onclick="showFormState('create_mode_state', null)">Create State</button>
</body>
</html>
