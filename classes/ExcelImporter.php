<?php
session_start();
require '../includes/header.php'; // Ensure the user is authenticated
require '../includes/config.php';
require '../vendor/autoload.php'; // Include Composer autoload
use App\Classes\ExcelImporter;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['excelFile']['tmp_name'];
        $fileName = $_FILES['excelFile']['name'];
        $fileSize = $_FILES['excelFile']['size'];
        $fileType = $_FILES['excelFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['xlsx', 'xls'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = '../uploads/';
            $dest_path = $uploadFileDir . $fileName;

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $importer = new ExcelImporter($pdo);
                $importer->import($dest_path);

                echo 'File is successfully uploaded and data is imported.';
            } else {
                echo 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
            }
        } else {
            echo 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        }
    } else {
        echo 'There is some error in the file upload. Please check the following error.<br>';
        echo 'Error:' . $_FILES['excelFile']['error'];
    }
}
?>
