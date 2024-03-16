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
<h2 id="responseMessageCity">&nbsp;</h2>

    <div id="updateTableContainerCity">
<?php
include("../db.php");
    $searchCity = isset($_POST['searchCity']) ? $_POST['searchCity'] : '';
$sql = "SELECT c.*, 
           st.state_name
        FROM cities c
        LEFT JOIN states st ON c.state_parent_id = st.state_id";
    if (!empty($searchCity)) {
    	$sql .= " WHERE city_name LIKE '$searchCity%'";
    }
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>State</th><th>City Name</th><th>City Status</th><th>Action</th></tr>"; 
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['city_id']}</td>";
        echo "<td>{$row['state_name']}</td>";
        echo "<td>{$row['city_name']}</td>";
        echo "<td>{$row['city_status']}</td>";
        echo "<td>";
        echo "<button onclick=\"showFormCity('edit_mode_city', {$row['city_id']})\">Edit</button>";
        echo "<button onclick=\"showFormCity('delete_mode_city', {$row['city_id']})\">Delete</button>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No cities found."; 
}

$conn->close();
?>

</div>
<div id="formContainerCity"></div>

<button onclick="showFormCity('create_mode_city', null)">Create City</button>
</body>
</html>
