<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: ../public/login.php');
    exit;
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (isset($_FILES['file'])) {
    if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['file']['tmp_name'];

        // Open the file for reading
        if (($handle = fopen($file, "r")) !== false) {
            $count = 0;

            // Connect to MySQL database
            $conn = new mysqli("localhost:4307", "root", "", "datamining");

            // Check connection
            if ($conn->connect_error) {
                echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
                exit;
            }

            // Prepare SQL statement for inserting data
            $stmt = $conn->prepare("INSERT INTO tb_trend (ADJ_LKPS, SEG_LKPS, BS_PL_LKPS_TOTAL, AS_OF_DATE, GL_ACCOUNT_ID, Account_Description, Opening_Balance, Debit, Credit, Ending_Balance, Adjustments, Revised_Balance, REP_LINE_DESC1, REP_LINE_DESC2, REP_LINE_DESC3, REP_LINE_DESC4, SEGMENT) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            // Check if the statement preparation was successful
            if ($stmt === false) {
                echo json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
                exit;
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
                        echo json_encode(["success" => false, "message" => "Error inserting row: " . $stmt->error]);
                        exit;
                    }
                }
            }

            // Close the prepared statement
            $stmt->close();

            // Close the file handle
            fclose($handle);

            echo json_encode(["success" => true, "message" => "$count records imported successfully!"]);
            exit;
        } else {
            echo json_encode(["success" => false, "message" => "Error opening the file."]);
            exit;
        }

        // Close the database connection
        $conn->close();
    } else {
        echo json_encode(["success" => false, "message" => "File upload error: " . $_FILES['file']['error']]);
        exit;
    }
} else {
    echo json_encode(["success" => false, "message" => "Form not submitted correctly."]);
    exit;
}
?>
