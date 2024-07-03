<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $file = $_FILES["file"]["tmp_name"];

        // Open the file for reading
        if (($handle = fopen($file, "r")) !== false) {
            $count = 0;

            // Connect to MySQL database
            $conn = new mysqli("localhost:4307", "root", "", "datamining");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare SQL statement for inserting data
            $stmt = $conn->prepare("INSERT INTO tb_trend (ADJ_LKPS, SEG_LKPS, BS_PL_LKPS_TOTAL, AS_OF_DATE, GL_ACCOUNT_ID, Account_Description, Opening_Balance, Debit, Credit, Ending_Balance, Adjustments, Revised_Balance, REP_LINE_DESC1, REP_LINE_DESC2, REP_LINE_DESC3, REP_LINE_DESC4, SEGMENT) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Check if the statement preparation was successful
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            // Bind parameters
            $stmt->bind_param("ssssssddddddddsss", $ADJ_LKPS, $SEG_LKPS, $BS_PL_LKPS_TOTAL, $AS_OF_DATE, $GL_ACCOUNT_ID, $Account_Description, $Opening_Balance, $Debit, $Credit, $Ending_Balance, $Adjustments, $Revised_Balance, $REP_LINE_DESC1, $REP_LINE_DESC2, $REP_LINE_DESC3, $REP_LINE_DESC4, $SEGMENT);

            // Skip the first row if it contains column headers
            if (($header = fgetcsv($handle, 1000, ",")) !== false) {
                // Loop through the CSV rows
                while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                    // Assign CSV column values to variables
                    list($ADJ_LKPS, $SEG_LKPS, $BS_PL_LKPS_TOTAL, $AS_OF_DATE, $GL_ACCOUNT_ID, $Account_Description, $Opening_Balance, $Debit, $Credit, $Ending_Balance, $Adjustments, $Revised_Balance, $REP_LINE_DESC1, $REP_LINE_DESC2, $REP_LINE_DESC3, $REP_LINE_DESC4, $SEGMENT) = $row;

                    // Execute SQL statement
                    if ($stmt->execute()) {
                        $count++;
                    } else {
                        echo "Error inserting row: " . $stmt->error . "<br>";
                    }
                }
            }

            // Close the prepared statement
            $stmt->close();

            // Close the file handle
            fclose($handle);

            echo "$count records imported successfully!";
        } else {
            echo "Error opening the file.";
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "File upload error: " . $_FILES["file"]["error"];
    }
}
?>
