<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: ../public/login.php');
    exit;
}

// Include any other necessary files
require '../includes/config.php';
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<?php
// Include header
include '../includes/header.php';
?>
<style>
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
    }
    .dz-message {
        margin: 20px 0;
    }
</style>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        // Include nav
        include '../includes/nav.php';
        ?>
           <!-- ========== App Menu ========== -->
           <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="../assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="../assets/images/logo-dark.png" alt="" height="21">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="../assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="../assets/images/logo-light.png" alt="" height="21">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            <?php include('../includes/scrollbar.php'); ?>
  

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <!-- Content goes here -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">File Upload</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">File Upload</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header"></div><!-- end card header -->

                                <div class="card-body">
                                    <form action="../public/upload.php" class="dropzone" id="my-dropzone" method="post" enctype="multipart/form-data">
                                        <div class="dz-message needsclick">
                                            <div class="mb-3">
                                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                            </div>
                                            <h4>Drop files here or click to upload.</h4>
                                        </div>
                                    </form>
                                    <button type="submit" form="my-dropzone" class="btn btn-primary mt-3 text-center">Upload</button>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php
            // Include footer
            include '../includes/footer.php';
            ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include('../includes/script.php'); ?>

    <!-- dropzone min -->
    <script src="../assets/libs/dropzone/dropzone-min.js"></script>
    <!-- SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#my-dropzone", {
            url: "../public/upload.php", // The PHP script that handles file uploads
            method: "post",
            paramName: "file", // The name of the file input field
            maxFilesize: 2, // Maximum file size in MB
            acceptedFiles: ".csv", // Accept only CSV files
            addRemoveLinks: true,
            init: function() {
                this.on("success", function(file, response) {
                    console.log(response); // Handle the server response here
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'File uploaded successfully. Click OK to proceed to the dashboard.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../public/dashboard.php';
                            }
                        });
                    } else {
                        alert(response.message);
                    }
                });
                this.on("error", function(file, response) {
                    console.log(response); // Handle errors here
                    alert("Error uploading file.");
                });
            }
        });
    </script>
</body>
</html>
