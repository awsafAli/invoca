<?php
require_once '../vendor/autoload.php';
require_once '../includes/config.php';
require_once '../includes/functions.php';

use App\DataFetcher;

secureSessionStart();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$dataFetcher = new DataFetcher();
$tableName = $_GET['table'] ?? 'tb_trend'; // Default to 'tb_trend'
$data = $dataFetcher->fetchTableData($tableName);

include '../includes/header.php';
include '../includes/navbar.php';
include '../templates/view_master_data.php';
include '../includes/footer.php';
?>
