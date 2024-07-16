<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require '../includes/config.php';
require '../vendor/autoload.php';

use App\DataFetcher;

// Include header
include '../includes/header.php';

$dataFetcher = new DataFetcher();

$tableName = 'tb_trend'; // Change as needed for other tables
$limit = 25; // Number of rows to fetch at a time
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0; // Current offset
$totalRows = $dataFetcher->countTableData($tableName); // Total rows in the table
$data = $dataFetcher->fetchTableData($tableName, $limit, $offset); // Fetch data with limit and offset

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Add necessary headers -->
</head>
<body>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include '../includes/nav.php'; ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Dashboard</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>ADJ LKPS</th>
                                    <th>SEG LKPS</th>
                                    <th>BS PL LKPS TOTAL</th>
                                    <th>AS OF DATE</th>
                                    <th>GL ACCOUNT ID</th>
                                    <th>Account Description</th>
                                    <th>Opening Balance</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Ending Balance</th>
                                    <th>Adjustments</th>
                                    <th>Revised Balance</th>
                                    <th>REP LINE DESC1</th>
                                    <th>REP LINE DESC2</th>
                                    <th>REP LINE DESC3</th>
                                    <th>REP LINE DESC4</th>
                                    <th>SEGMENT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $row): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['ADJ_LKPS']); ?></td>
                                        <td><?php echo htmlspecialchars($row['SEG_LKPS']); ?></td>
                                        <td><?php echo htmlspecialchars($row['BS_PL_LKPS_TOTAL']); ?></td>
                                        <td><?php echo htmlspecialchars($row['AS_OF_DATE']); ?></td>
                                        <td><?php echo htmlspecialchars($row['GL_ACCOUNT_ID']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Account_Description']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Opening_Balance']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Debit']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Credit']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Ending_Balance']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Adjustments']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Revised_Balance']); ?></td>
                                        <td><?php echo htmlspecialchars($row['REP_LINE_DESC1']); ?></td>
                                        <td><?php echo htmlspecialchars($row['REP_LINE_DESC2']); ?></td>
                                        <td><?php echo htmlspecialchars($row['REP_LINE_DESC3']); ?></td>
                                        <td><?php echo htmlspecialchars($row['REP_LINE_DESC4']); ?></td>
                                        <td><?php echo htmlspecialchars($row['SEGMENT']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="pagination">
                            <?php if ($offset > 0): ?>
                                <a href="?offset=<?php echo $offset - $limit; ?>">Previous</a>
                            <?php endif; ?>
                            <?php if ($offset + $limit < $totalRows): ?>
                                <a href="?offset=<?php echo $offset + $limit; ?>">Next</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Include necessary scripts -->
<?php include('../includes/script.php'); ?>

</body>
</html>
