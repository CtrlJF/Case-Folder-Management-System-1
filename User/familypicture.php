<?php
session_start();

// Check if the user is not logged in, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: pages/login.php");
    exit;
}

require_once 'server/displays/fampick_display.php';

?>

<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <!-- <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css"> -->
    <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css">
    <link rel="icon" type="image/png" href="assets/images/dswd-logo.png">
    <title> Family Picture </title>
    <script src="functions/fampick.js"></script>

    <style>
        .product-img-head {
            overflow: hidden;
            height: 100%; /* Adjust as needed */
        }
        .cover-image {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>

</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="index.php">DSWD 4p's CFMS</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="fa fa-fw fa-user-circle"></i></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item dropdown connection"></li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/avatar2.png" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">
                                        <?php 
                                            echo !empty($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Guest';
                                        ?>  
                                    </h5>
                                    <span class="status"></span><span class="ml-2">user</span>
                                </div>
                                <a class="dropdown-item" href="index.php"><i class="fas fa-user mr-2"></i>Account</a>
                                <!-- <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a> -->
                                <a class="dropdown-item" href="#" onclick="confirmLogout()"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Menu</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                USER
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " href="index.php" ><i class="fa fa-fw fa-user-circle"></i>Profile<span class="badge badge-success"></span></a>
                            </li> 
                            <li class="nav-item ">
                                <a class="nav-link active" href="#" onclick="toggleFolderIconUser()" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fas fa-folder" id="folderIconUser"></i>Case Folder <span class="badge badge-success">6</span></a>
                                <div id="submenu-1" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-2" aria-controls="submenu-1-2">ID's</a>
                                            <div id="submenu-1-2" class="collapse submenu" >
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="nationalID.php">National ID</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="pantawidID.php">Pantawid ID</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="cashcard.php">Cash Card</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="familypicture.php">Family Picture</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="kasabutan.php">Kasabutan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="birthcert.php">Birth Certificate</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="marriagecont.php">Marriage Contract</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="immurec.php">Immunization Record</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="gradecards.php">Grade Cards</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="mdr.php">MDR</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="certattendance.php">Certificate of Attendance on Trainings Attended</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="beneprofile.php">Beneficiary Profile</a>
                                        </li>
                                    </ul>
                                </div>
                            </li> 
                            <li class="nav-divider">
                                ADMIN
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" onclick="toggleFolderIcon()" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-folder" id="folderIcon"></i> Pages </a>
                                <div id="submenu-6" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="gis.php">GIS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="swdi.php">SWDI Result</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="haf.php">HAF</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="scsr.php">Social Case Study Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="car.php">Case Assessment Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="aer.php">Annual Evaluation Report</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pn.php">Progress Notes</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="psms.php">PSMS</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="rl.php">Referral Letters</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li> 
                        </ul>
                    </div>

                </nav>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Family Picture</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#idForm">
                                                ADD <i class="fas fa-plus"></i>
                                            </button>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget">
                        <div class="row">
                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
                                <div class="row">

                                    <?php
                                        if ($stmt->rowCount() > 0) {
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                echo "<div class='col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12'>";
                                                echo "<div class='product-thumbnail'>";
                                                echo "<div class='product-img-head'>";

                                                // Display image if available
                                                if (!empty($row['img'])) {
                                                    $filePath = '../uploads/fampick/' . $row['img'];
                                                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                                
                                                    if ($extension == 'pdf') {
                                                        echo "<a href='{$filePath}' target='_blank'><strong>View PDF</strong></a>";
                                                    }else if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                                        // Display full-screen link for JPEG and PNG images
                                                        echo "<a href='{$filePath}' target='_blank'><img src='{$filePath}' alt='img' class='cover-image'></a>";
                                                    }else {
                                                        echo "<img src='../uploads/fampick/{$row['img']}' alt='img' class='cover-image'>";
                                                    }
                                                } else {
                                                    echo "<img src='assets/images/avatar-2.jpg' alt='img' class='cover-image'>";
                                                }

                                                // Assuming $row['upload'] contains the date string
                                                $dateString = $row['upload'];

                                                // Create a DateTime object
                                                $date = new DateTime($dateString);

                                                // Format the date to display only the year
                                                $year = $date->format('Y');

                                                echo "</div>";
                                                echo "<div class='product-content'>";
                                                echo "<div class='product-content-head'>";
                                                echo "<h3 class='product-title'>" . $row['name'] . "</h3>";
                                                echo "<div class='product-price text-primary'>" . $year . "</div>";
                                                echo "</div>";
                                                echo "<div class='product-content-head'>";
                                                echo "<a href='#' class='btn btn-primary mr-2' onclick=\"document.getElementById('file-input-{$row['id']}').click(); return false;\">Upload</a>";
                                                echo "<input id='file-input-{$row['id']}' type='file' style='display: none;' accept='image/jpeg,image/png,application/pdf' data-user-fam-pick='{$row['id']}' onchange='handleFileSelect(event)'>";    
                                                

                                                if (!empty($row['img']) && file_exists("../uploads/fampick/{$row['img']}")) {
                                                    echo "<a href='#' class='btn btn-info mr-2 printButton' data-img-src='../uploads/fampick/{$row['img']}'> Print </a>";
                                                } else {
                                                    // Handle case where img is empty or file does not exist
                                                    echo "<span class='btn btn-info mr-2 disabled'> Print </span>";
                                                }

                                                
                                                echo "<button type='button' class='btn btn-danger delButton' data-toggle='modal' data-target='#delForm' data-user-fam-pick='{$row['id']}'>Delete</button>";
                                                echo "</div>";
                                                echo "<div class='product-content-foot row'>";
                                                echo "<div class='col-md-6'>";
                                                echo "<p class='mb-0'>";
                                                $icolor = $row['status'] === 'rejected' ? 'text-danger' : ($row['status'] === 'approved' ? 'text-success' : 'text-primary');
                                                echo "Status: <span class=". $icolor .">". $row['status'] . "</span>";
                                                echo "</p>";
                                                echo "</div>";
                                                echo "<div class='col-md-6 text-md-right'>";
                                                echo "<a href='#' data-toggle='modal' data-target='#remarks' data-type='Family_Photo' data-row-id='{$row['id']}'>Remarks</a>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</div>";
                                                echo "</div>";
                                               /*  echo ""; */
                                            }
                                        }
                                    ?>
                                    
                                </div> 
                            </div>

                        </div>
                    </div>
                </div>

            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            Copyright © 2024. All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- start modal  -->
        <!-- ============================================================== -->
        <div class="modal fade" id="idForm" tabindex="-1" role="dialog" aria-labelledby="idFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idFormLabel">Fill Up Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="server/create/fampick_create.php" method="post">
                            <div class="form-group">
                                <label for="name">name:</label>
                                <input type="text" id="name" name="name" class="form-control" required readonly value="Family Photo">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="delForm" tabindex="-1" role="dialog" aria-labelledby="idFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idFormLabel">Confirmation Message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <form action="server/delete/fampick_delete.php" method="post">
                            <div class="form-group">
                                <p>Delete Information ?</p>
                                <input type="hidden" id="userIdInput" name="userId" value="">
                            </div>
                            <div class="text-right"> <!-- Align the button to the right -->
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="remarks" tabindex="-1" role="dialog" aria-labelledby="idFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idFormLabel">Remarks</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                <div id="remarksContent"> <!-- Content will be updated here --> </div>
                            </div>
                            <div class="text-right"> <!-- Align the button to the right -->
                                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close" >
                                    <span>Close</span>
                                </button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end modal  -->
        <!-- ============================================================== --> 
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <!-- <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script> -->
    <!-- main js -->
    <!-- <script src="assets/libs/js/main-js.js"></script> -->

    <script>

    // Function to toggle the folder icon
    function toggleFolderIcon() {
        var folderIcon = document.getElementById("folderIcon");
        if (folderIcon.classList.contains("fa-folder")) {
            folderIcon.classList.remove("fa-folder");
            folderIcon.classList.add("fa-folder-open");
        } else {
            folderIcon.classList.remove("fa-folder-open");
            folderIcon.classList.add("fa-folder");
        }
    }
    function toggleFolderIconUser() {
        var folderIcon = document.getElementById("folderIconUser");
        if (folderIcon.classList.contains("fa-folder")) {
            folderIcon.classList.remove("fa-folder");
            folderIcon.classList.add("fa-folder-open");
        } else {
            folderIcon.classList.remove("fa-folder-open");
            folderIcon.classList.add("fa-folder");
        }
    }

    // Add an event listener to toggle the icon when clicked
    document.getElementById("submenu-6").addEventListener("show.bs.collapse", toggleFolderIcon);
    document.getElementById("submenu-6").addEventListener("hide.bs.collapse", toggleFolderIcon);
    document.getElementById("submenu-1").addEventListener("show.bs.collapse", toggleFolderIcon);
    document.getElementById("submenu-1").addEventListener("hide.bs.collapse", toggleFolderIcon);


    function confirmLogout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = 'server/logout.php';
        }
    }

    $(document).ready(function() {
        // When the modal is about to be shown
        $('#delForm').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userId = button.data('user-fam-pick'); // Extract info from data-* attributes
            console.log(userId);
            // Update the userIdInput value
            $('#userIdInput').val(userId);
        });

        // Event handler for the print button click
        $('.printButton').click(function(e) {
            e.preventDefault();

            var imgSrc = $(this).data('img-src');
            if (imgSrc) {
                var printWindow = window.open(imgSrc, '_blank');
                printWindow.onload = function() {
                    printWindow.print();
                };
            } else {
                alert('Image source is not valid or not found.');
            }
            
        });

        $('#remarks').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('row-id'); // Extract info from data-* attributes
            var type = button.data('type');

            console.log(type);
            console.log(id);

            // Use AJAX to fetch data from the server
            $.ajax({
                url: 'server/fetch/remarks.php', // PHP file to handle the request
                type: 'POST',
                data: { id: id, type: type },
                success: function(response) {
                    // Update modal content with the fetched data
                    $('#remarksContent').html(response);
                },
                error: function() {
                    $('#remarksContent').html('Failed to load data.');
                }
            });
        });

    });

    </script>
</body>
 
</html>