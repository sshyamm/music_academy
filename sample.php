foreach ($students as $student) {
    echo "<tr>";
    echo "<td>" . $count . "</td>";
    echo "<td>" . $student['name'] . "</td>";
    echo "<td>" . $student['email'] . "</td>";
    if ($_SESSION['user_type'] == 'Teacher') {
        echo "<td class=\"attendance-column\"";
        if (!$attendanceVisible) echo " style=\"display: none;\"";
        echo ">
            <select class='form-control attendance-dropdown'>
                <option value='Select'>Select</option>
                <option value='Present'>Present</option>
                <option value='Absent'>Absent</option>
                <option value='Late'>Late</option>
            </select>
        </td>";
        echo "<td>
            <button class='btn btn-danger btn-sm delete-btn'>Delete</button>
        </td>";
        echo "<td style='display: none;'><input type='hidden' class='class_room_id' value='" . $student['class_room_id'] . "'></td>";
    }
    echo "</tr>";
    $count++;
}