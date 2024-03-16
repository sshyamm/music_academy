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
        #responseMessageCountry {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageCountry">&nbsp;</h2>

    <div id="updateTableContainerCountry">
    <?php
    include("../db.php");
    $searchCountry = isset($_POST['searchCountry']) ? $_POST['searchCountry'] : '';
    $sql = "SELECT * FROM countries";
    if (!empty($searchCountry)) {
    	$sql .= " WHERE country_name LIKE '$searchCountry%'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Country Name</th><th>Country Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['country_id']}</td>";
            echo "<td>{$row['country_name']}</td>";
            echo "<td>{$row['country_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormCountry('edit_mode_country', {$row['country_id']})\">Edit</button>";
            echo "<button onclick=\"showFormCountry('delete_mode_country', {$row['country_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No Countries found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerCountry"></div>

<button onclick="showFormCountry('create_mode_country', null)">Create Level</button>
</body>
</html>
