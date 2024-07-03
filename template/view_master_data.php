<?php
session_start();
require '../includes/config.php';
require '../classes/Database.php';
require '../classes/DataFetcher.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch data for each master table
$dataFetcher = new DataFetcher();
$masterData1 = $dataFetcher->fetchTableData('master_table1');
$masterData2 = $dataFetcher->fetchTableData('master_table2');
$masterData3 = $dataFetcher->fetchTableData('master_table3');
?>

<!doctype html>
<html lang="en">
<?php include '../includes/header.php'; ?>
<body>
    <div id="layout-wrapper">
        <?php include '../includes/nav.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Master Data View</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Display Data for Master Table 1 -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Master Table 1 Records</h4>
                                </div>
                                <div class="card-body">
                                    <?php include '../templates/data_table.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Data for Master Table 2 -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Master Table 2 Records</h4>
                                </div>
                                <div class="card-body">
                                    <?php include '../templates/data_table.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Data for Master Table 3 -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Master Table 3 Records</h4>
                                </div>
                                <div class="card-body">
                                    <?php include '../templates/data_table.php'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
    <?php include '../includes/script.php'; ?>
</body>
</html>
