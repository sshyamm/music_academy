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
        #responseMessageCmt {
           height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageNews">&nbsp;</h2>

<div id="updateTableContainerNews">
    <?php
    include("../db.php");
    $sql = "SELECT * FROM news";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Email</th><th>Created At</th><th>News Status</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['news_id']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['news_status']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormNews('edit_mode_news', {$row['news_id']})\">Edit</button>";
            echo "<button onclick=\"showFormNews('delete_mode_news', {$row['news_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No news found."; 
    }

    $conn->close();
    ?>
</div>
<div id="formContainerNews"></div>

<button onclick="showFormNews('create_mode_news', null)">Create News</button>

</body>
</html>
