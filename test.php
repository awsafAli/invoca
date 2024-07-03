<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: ../public/login.php');
    exit;
}
?>

<?php


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

        // Include header
        include '../includes/nav.php';


        ?>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="21">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="21">
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
        <!-- <div class="vertical-overlay"></div> -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
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
                                <div class="card-header">
                                    <!-- <h4 class="card-title mb-0">Dropzone</h4> -->
                                </div><!-- end card header -->

                                <div class="card-body">
                                  
                                <form action="../public/upload.php" method="POST" enctype="multipart/form-data">
    <div class="dropzone">
        <div class="fallback">
            <input type="file" name="file" accept=".csv">
        </div>
        <div class="dz-message needsclick">
            <div class="mb-3">
                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
            </div>
            <h4>Drop files here or click to upload.</h4>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-4">
        <button type="submit" name="submit" class="btn btn-primary">Upload</button>
    </div>
</form>


                                 
                                 
                                 
                                 

                                    <!-- <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="dropzone">
                <div class="fallback">
                    <input type="file" name="file" accept=".csv">
                </div>
                <div class="dz-message needsclick">
                    <div class="mb-3">
                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                    </div>
                    <h4>Drop files here or click to upload.</h4>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center mt-4">
                <button type="submit" name="submit" class="btn btn-primary">Upload</button>
            </div>
        </form> -->
                                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                                        <li class="mt-2" id="dropzone-preview-list">
                                            <!-- This is used as the file preview template -->
                                            <div class="border rounded">
                                                <div class="d-flex p-2">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm bg-light rounded">
                                                            <img data-dz-thumbnail class="img-fluid rounded d-block" src="../assets/images/new-document.png" alt="Dropzone-Image" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="pt-1">
                                                            <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                            <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-3">
                                                        <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <!-- end dropzon-preview -->
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

            // Include header
            include '../includes/footer.php';


            ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <?php include('../includes/script.php'); ?>
    

    <!-- dropzone min -->
    <script src="../assets/libs/dropzone/dropzone-min.js"></script>

    <!-- <script src="../assets/js/pages/form-file-upload.init.js"></script> -->



    
</html>
