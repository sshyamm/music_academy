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
        #responseMessageImg {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageImg">&nbsp;</h2>

    <div id="updateTableContainerImg">
    <?php
    include("../db.php");
    $sql = "SELECT * FROM images";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Image Name</th><th>Image Path</th><th>Image Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['image_id']}</td>";
            echo "<td>{$row['image_name']}</td>";
            echo "<td><img src='getForms/img/{$row['image_path']}' alt='Image'></td>";
            echo "<td>{$row['image_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormImg('edit_mode_img', {$row['image_id']})\">Edit</button>";
            echo "<button onclick=\"showFormImg('delete_mode_img', {$row['image_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No images found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerImg"></div>

<button onclick="showFormImg('create_mode_img', null)">Create Image</button>
</body>
</html>
