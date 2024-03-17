<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
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
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        #responseMessageStudent {
            height: 20px; 
        }
    </style>
</head>
<body>
<h2 id="responseMessageStudent">&nbsp;</h2>
<button type="button" onclick="selectFile();">Import Students</button>
<div id="updateTableContainerStudent">
    <?php
    include("../db.php");
    $searchId = isset($_POST['searchId']) ? $_POST['searchId'] : '';
    $searchName = isset($_POST['searchName']) ? $_POST['searchName'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $level = isset($_POST['level']) ? $_POST['level'] : '';
    $country = isset($_POST['country']) ? $_POST['country'] : '';
    $state = isset($_POST['state']) ? $_POST['state'] : '';
    $city = isset($_POST['city']) ? $_POST['city'] : '';
    $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
    $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';

    $sql = "SELECT s.*, us.user_name, ag.age_group_name, c.course_name, l.level_name, ci.city_name, st.state_name, co.country_name
            FROM students s
            LEFT JOIN users us ON s.user_parent_id = us.user_id
            LEFT JOIN age_groups ag ON s.age_group_parent_id = ag.age_group_id
            LEFT JOIN courses c ON s.course_parent_id = c.course_id
            LEFT JOIN levels l ON s.level_parent_id = l.level_id
            LEFT JOIN cities ci ON s.city_parent_id = ci.city_id
            LEFT JOIN states st ON s.state_parent_id = st.state_id
            LEFT JOIN countries co ON s.country_parent_id = co.country_id";

    $whereClause = " WHERE 1=1";

    if (!empty($searchId)) {
        $whereClause .= " AND s.student_id LIKE '%$searchId%'";
    }

    if (!empty($searchName)) {
        $whereClause .= " AND us.user_name LIKE '$searchName%'";
    }

    if (!empty($age)) {
        $whereClause .= " AND s.age_group_parent_id = '$age'";
    }

    if (!empty($course)) {
        $whereClause .= " AND s.course_parent_id = '$course'";
    }

    if (!empty($level)) {
        $whereClause .= " AND s.level_parent_id = '$level'";
    }

    if (!empty($country)) {
        $whereClause .= " AND s.country_parent_id = '$country'";
    }

    if (!empty($state)) {
        $whereClause .= " AND s.state_parent_id = '$state'";
    }

    if (!empty($city)) {
        $whereClause .= " AND s.city_parent_id = '$city'";
    } elseif (!empty($fromDate) && empty($toDate)) {
        if (!empty($whereClause)) {
            $whereClause .= " AND ";
        } else {
            $whereClause = " WHERE ";
        }
        $whereClause .= " s.joined_date >= '$fromDate'";
    } elseif (empty($fromDate) && !empty($toDate)) {
        if (!empty($whereClause)) {
            $whereClause .= " AND ";
        } else {
            $whereClause = " WHERE ";
        }
        $whereClause .= " s.joined_date <= '$toDate'";
    } elseif (!empty($fromDate) && !empty($toDate)) {
        if (!empty($whereClause)) {
            $whereClause .= " AND ";
        } else {
            $whereClause = " WHERE ";
        }
        $whereClause .= " s.joined_date BETWEEN '$fromDate' AND '$toDate'";
    }

    $sql .= $whereClause;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Student Username</th><th>Phone Number</th><th>Email</th><th>Age Group</th><th>Course</th><th>Level</th><th>Emergency Contact</th><th>Blood Group</th><th>Address</th><th>Pincode</th><th>City</th><th>State</th><th>Country</th><th>Student Status</th><th>Joined Date</th><th>Action</th></tr>"; 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['student_id']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['phone_num']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['age_group_name']}</td>";
            echo "<td>{$row['course_name']}</td>";
            echo "<td>{$row['level_name']}</td>";
            echo "<td>{$row['emergency_contact']}</td>";
            echo "<td>{$row['blood_group']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['pincode']}</td>";
            echo "<td>{$row['city_name']}</td>";
            echo "<td>{$row['state_name']}</td>";
            echo "<td>{$row['country_name']}</td>";
            echo "<td>{$row['student_status']}</td>";
            echo "<td>{$row['joined_date']}</td>";
            echo "<td>";
            echo "<button onclick=\"showFormStudent('edit_mode_student', {$row['student_id']})\">Edit</button>";
            echo "<button onclick=\"showFormStudent('delete_mode_student', {$row['student_id']})\">Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No students found."; 
    }
    $conn->close();
    ?>
</div>

<div id="formContainerStudent"></div>

<button onclick="showFormStudent('create_mode_student', null)">Create Student</button>
</body>
</html>