<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: pages/login.php");
    exit;
}

require_once 'server/display/reports_display.php';
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
    <link rel="icon" type="image/png" href="assets/images/dswd-logo.png">
    <!-- <link rel="stylesheet" href="assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css"> -->
   <!--  <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css"> -->
    <title> Admin Reports </title>
    <style>
        button.text-white:hover {
            background-color: #212529;
        }
        button.text-white:active {
            background-color: #212529 !important;
        }
        .notification-badge {
            display: inline-block;
            width: 20px; 
            height: 20px; 
            background-color: #dc3545; 
            border-radius: 50%; 
            text-align: center;
            line-height: 20px; 
            font-size: 12px; 
            margin-left: 12px; 
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
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input id="global-search" class="form-control" type="text" placeholder="Search Barangay ...">
                            </div>
                        </li>
                        
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/img_avatar.png" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">
                                        <?php
                                            echo !empty($_SESSION['fname']) && !empty($_SESSION['lname']) ? $_SESSION['fname'] . ' ' . $_SESSION['lname'] : 'Guest';
                                        ?>
                                    </h5>
                                    <span class="status"></span><span class="ml-2">admin</span>
                                </div>
                                <a class="dropdown-item" href="#" data-toggle='modal' data-target='#view'><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#" data-toggle='modal' data-target='#change_pass' ><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="#" onclick="confirmLogout()"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="idFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idFormLabel">Admin Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="text-dark">ID Number</div>
                                    <span> <?php echo !empty($_SESSION['id_no']) ? $_SESSION['id_no'] : "Data not found!"; ?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="text-dark">First Name</div>
                                    <span> <?php echo !empty($_SESSION['fname']) ? $_SESSION['fname'] : "Data not found!"; ?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="text-dark">Middle Name</div>
                                    <span><?php echo !empty($_SESSION['mname']) ? $_SESSION['mname'] : " "; ?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="text-dark">Last Name</div>
                                    <span> <?php echo !empty($_SESSION['lname']) ? $_SESSION['lname'] : "Data not found!"; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Okay</button>
                    </div>
                </div>
            </div>
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
                                Menu
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="index.php"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="Chart.php"><i class="fas fa-fw fa-chart-pie"></i>Chart</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="Reports.php"><i class="fab fa-fw fa-wpforms"></i>Reports</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Search.php"><i class="fas fa-search"></i>All Documents</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-2" aria-controls="submenu-1-2"><i class="fas fa-user-plus"></i>Create User Account</a>
                                <div id="submenu-1-2" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="CreateUser.php">User</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="CreateAdmin.php">Admin</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pendingUsers.php">
                                    <i class="fas fa-spinner fa-spin"></i>
                                        Pending User Account
                                    <span id="pendingCount" class="text-light notification-badge" style="display: none;"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pendingDocs.php">
                                    <i class="fas fa-spinner fa-spin"></i></i>
                                        Pending Documents
                                    <span id="pendocCount" class="text-light notification-badge" style="display: none;"></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="submitDocs.php"><i class="fas fa-paper-plane"></i>Send Documents</i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="dropgrantee.php"><i class="fas fa-check-circle"></i>Drop Grantee</i></a>
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
                                <h2 class="pageheader-title"> Reports </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="Reports.php" class="btn btn-secondary" >Refresh</a></li>
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
                           <?php foreach ($barangayGroups as $barangay => $yearlyCounts) {
                            $counts = [];

                            // If a specific year is selected, get the counts for that year
                            if ($selectedYear && isset($yearlyCounts[$selectedYear])) {
                                $counts = $yearlyCounts[$selectedYear];
                            } else {
                                // If no specific year is selected, sum counts for all years
                                foreach ($yearlyCounts as $year => $docCounts) {
                                    foreach ($docCounts as $docType => $count) {
                                        if (!isset($counts[$docType])) {
                                            $counts[$docType] = 0; // Initialize if not set
                                        }
                                        $counts[$docType] += $count; // Sum counts
                                    }
                                }
                            }
    // Only display the barangay if it is the selected barangay or no barangay is selected
    if ($selectedBarangay === null || $selectedBarangay === $barangay) {
        ?>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 document-card" id="results-container">
            <div class="card">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white"><?php echo htmlspecialchars($barangay); ?></h5>
                    <div class="dropdown d-flex">
                        <a class="btn btn-light mr-3" href='print.php?barangay=<?php echo urlencode($barangay); ?>' target="_blank"><i class="fas fa-print btn text-dark"> Print</i></a>
                        <button class="btn btn-outline-light dropdown-toggle text-white" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $selectedYear ? $selectedYear : "Choose a year"; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php foreach (array_keys($yearlyCounts) as $year): ?>
                                <li><a class="dropdown-item" href="?year=<?php echo $year; ?>&barangay=<?php echo urlencode($barangay); ?>"><?php echo $year; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 504px; overflow-y: auto; display: flex; flex-wrap: wrap;">
                        <?php foreach ($docTypeMap as $docType => $docTypeName): 
                            // Use the selected year's count, default to 0 if not set
                            $count = $counts[$docTypeName];?>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card mt-4 border">
                                    <a href="print.php?table=<?php echo $docType; ?>&barangay=<?php echo urlencode($barangay); ?>" target="_blank" class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted"><?php echo htmlspecialchars($docTypeName); ?></h5>
                                            <h2 class="mb-0"><?php echo htmlspecialchars($count); ?></h2>
                                        </div>
                                        <?php 
                                            // Assign icons and colors based on the document type
                                            $icons = [
                                                'National ID' => 'fa-image',
                                                'Family Picture' => 'fa-image',
                                                'Pantawid ID' => 'fa-id-card',
                                                'Cash Card' => 'fa-id-card',
                                                'Kasabutan' => 'fa-file-alt',
                                                'Birth Certificate' => 'fa-file-alt',
                                                'Marriage Contract' => 'fa-file-alt',
                                                'Immunization Record' => 'fa-file-alt',
                                                'Grade Cards' => 'fa-id-card',
                                                'MDR' => 'fa-file-alt',
                                                'Attendance on Training' => 'fa-file-alt',
                                                'Beneficiary Profile' => 'fa-file-alt',
                                            ];
                                            $colors = [
                                                'National ID' => 'text-info',
                                                'Family Picture' => 'text-brand',
                                                'Pantawid ID' => 'text-secondary',
                                                'Cash Card' => 'text-success',
                                                'Kasabutan' => 'text-danger',
                                                'Birth Certificate' => 'text-brand',
                                                'Marriage Contract' => 'text-primary',
                                                'Immunization Record' => 'text-dark',
                                                'Grade Cards' => 'text-light',
                                                'MDR' => 'text-info',
                                                'Attendance on Training' => 'text-info',
                                                'Beneficiary Profile' => 'text-info',
                                            ];
                                            $bgcolors = [
                                                'National ID' => 'bg-info-light',
                                                'Family Picture' => 'bg-brand-light',
                                                'Pantawid ID' => 'bg-secondary-light',
                                                'Cash Card' => 'bg-success-light',
                                                'Kasabutan' => 'bg-danger-light',
                                                'Birth Certificate' => 'bg-brand-light',
                                                'Marriage Contract' => 'bg-primary-light',
                                                'Immunization Record' => 'bg-light',
                                                'Grade Cards' => 'bg-dark',
                                                'MDR' => 'bg-info-light',
                                                'Attendance on Training' => 'bg-info-light',
                                                'Beneficiary Profile' => 'bg-info-light',
                                            ];
                                            $iconClass = isset($icons[$docTypeName]) ? $icons[$docTypeName] : 'fa-file';
                                            $bgColClass = isset($bgcolors[$docTypeName]) ? $bgcolors[$docTypeName] : 'bg-light';
                                            $colorClass = isset($colors[$docTypeName]) ? $colors[$docTypeName] : 'text-info';
                                        ?>
                                        <div class="float-right icon-circle-medium icon-box-lg <?php echo htmlspecialchars($bgColClass); ?> mt-1">
                                            <i class="fas <?php echo htmlspecialchars($iconClass); ?> fa-fw fa-sm <?php echo htmlspecialchars($colorClass); ?>"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

                            
                            

                            


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
        <div class="modal fade" id="change_pass" tabindex="-1" role="dialog" aria-labelledby="idFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idFormLabel">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <form action="server/update/password_update.php" method="post">
                            <!-- Hidden username field for accessibility -->
                            <input type="text" id="username" name="username" style="display:none;" aria-hidden="true" autocomplete="username">
                            <div class="form-group">
                                <input class="form-control form-control-lg" type="password" id="password" name="password"  required placeholder="Enter New Password" autocomplete="new-password">
                            </div>
                            <div class="text-right"> 
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    <!-- Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


    <script>

        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = 'server/logout.php';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const dropdownItems = document.querySelectorAll('.dropdown-item');

            dropdownItems.forEach(item => {
                item.addEventListener('click', function () {
                    const dropdownToggle = this.closest('.dropdown').querySelector('.dropdown-toggle');
                    dropdownToggle.innerText = this.innerText; // Update button text with selected year
                });
            });

                // Global search functionality
                const globalSearchInput = document.getElementById('global-search');
                
                globalSearchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const documentCards = document.querySelectorAll('.document-card');
                    
                    documentCards.forEach(function(card) {
                        const docName = card.querySelector('.card-header h5').textContent.toLowerCase();
                        
                        if (docName.includes(searchTerm)) {
                            card.style.display = ''; // Show card
                        } else {
                            card.style.display = 'none'; // Hide card
                        }
                    });
                });
        });


        $(document).ready(function() {
            $.ajax({
                url: 'server/fetch_data/count_user.php', // A PHP script to return the count
                method: 'POST',
                success: function(response) {
                    var count = parseInt(response, 10); // Convert response to an integer
                    if (isNaN(count) || count <= 0) {
                        $('#pendingCount').hide(); // Hide the badge if count is 0 or invalid
                    } else {
                        $('#pendingCount').text(count).show(); // Show the badge and update text if count is greater than 0
                    }
                },
                error: function() {
                    $('#pendingCount').hide(); // Hide the badge on error
                }
            });

            $.ajax({
                url: 'server/fetch_data/count_doc.php', // A PHP script to return the count
                method: 'POST',
                success: function(response) {
                    var count = parseInt(response, 10); // Convert response to an integer
                    if (isNaN(count) || count <= 0) {
                        $('#pendocCount').hide(); // Hide the badge if count is 0 or invalid
                    } else {
                        $('#pendocCount').text(count).show(); // Show the badge and update text if count is greater than 0
                    }
                },
                error: function() {
                    $('#pendocCount').hide();
                }
            });
            
        });


    </script>
</body>
 
</html>