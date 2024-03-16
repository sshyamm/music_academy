<?php
// upload.php

require_once('../db.php');

// Check if a file was uploaded
if(isset($_FILES['fileToUpload'])) {
    $file = $_FILES['fileToUpload'];

    // Check for errors
    if($file['error'] === UPLOAD_ERR_OK) {
        // Get file extension
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);

        // Check if the file is a CSV
        if($fileExt === 'csv') {
            // Open the CSV file for reading
            $fileHandle = fopen($file['tmp_name'], 'r');

            // Skip the first row (header row)
            fgetcsv($fileHandle);

            // Initialize array to store usernames of records with empty fields or duplicates
            $invalidRecords = array();

            // Read the CSV file line by line
            while(($data = fgetcsv($fileHandle)) !== FALSE) {
                // Check if any required field is empty
                $isEmptyField = false;
                foreach($data as $value) {
                    if(empty($value)) {
                        $isEmptyField = true;
                        break;
                    }
                }

                // If any required field is empty, skip this record
                if($isEmptyField) {
                    $invalidRecords[] = $data[0]; // Store username of record with empty fields
                    continue;
                }

                // Prepare the data for insertion
                $values = array_map(array($conn, 'real_escape_string'), $data);

                // Convert date format from dd-mm-yyyy to yyyy-mm-dd
                $joined_date = implode('-', array_reverse(explode('-', $values[15])));

                // Check if the record already exists
                $existingRecordQuery = "SELECT student_username FROM students WHERE student_username = '$values[0]'";
                $result = $conn->query($existingRecordQuery);

                if($result->num_rows > 0) {
                    // If a duplicate record is found, skip this record
                    $invalidRecords[] = $values[0]; // Store username of duplicate record
                    continue;
                }

                // Insert data into the database
                $sql = "INSERT INTO students (student_username, student_password, phone_num, email, age_group_parent_id, course_parent_id, level_parent_id, emergency_contact, blood_group, address, pincode, city_parent_id, state_parent_id, country_parent_id, student_status, joined_date) VALUES ('$values[0]', '$values[1]', '$values[2]', '$values[3]', '$values[4]', '$values[5]', '$values[6]', '$values[7]', '$values[8]', '$values[9]', '$values[10]', '$values[11]', '$values[12]', '$values[13]', '$values[14]', '$joined_date')";

                // Execute the SQL query
                if ($conn->query($sql) === TRUE) {
                    echo "Data inserted successfully.\n";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Close the file handle
            fclose($fileHandle);

            // If there were records with empty fields or duplicates, display the corresponding message
            if(!empty($invalidRecords)) {
                echo "Records with empty fields or duplicates skipped: " . implode(', ', $invalidRecords);
            }
        } else {
            echo "Only CSV files are allowed.";
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file uploaded.";
}
?>
