<?php
// Start the session to access session variables
session_start();

// Check if the user is not logged in, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: pages/login.php");
    exit;
}

require_once(__DIR__ . '/../libraries/database.php');
require_once 'server/profileinfo.php';


// If logged in and the alert has not been shown before
if (!isset($_SESSION['alert_shown']) || $_SESSION['alert_shown'] === false) {
    // Display the alert using information from $data if available, otherwise display a generic alert
    echo "<script>alert('Welcome, " . (!empty($data) ? $data['fname'] . " " . $data['lname'] : "Guest") . "!');</script>";

    // Set the flag to true to indicate that the alert has been shown
    $_SESSION['alert_shown'] = true;

}

// Set $_SESSION['fullname'] if $data['fname'] and $data['lname'] are both present
$_SESSION['fullname'] = (!empty($data['fname']) && !empty($data['lname'])) ? $data['fname'] . " " . $data['lname'] : "";

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
    <title> User Main Page</title>
    <style>
        @media (max-width: 480px) {
            .table {
                min-width: 785px;
            }
            form .card-body {
                padding: 10px;
            }
            
            form .row {
                display: block;
                margin-bottom: 15px;
            }

            form .col {
                width: 100%;
                margin-bottom: 10px;
            }

            form .col h6 {
                font-size: 14px;
                margin-bottom: 5px;
            }

            form .col p {
                font-size: 16px;
                margin-bottom: 5px;
            }

            form .form-control {
                width: 100%;
            }

            form .btn {
                width: 100%;
                margin-top: 10px;
            }
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
                                            /* echo isset($_SESSION['fname']) && isset($_SESSION['lname']) ? $_SESSION['fname'] . ' ' . $_SESSION['lname'] : 'Guest'; */ 
                                            echo !empty($data) ? $data['fname'] . ' ' . $data['lname'] : 'Guest';
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
                                <a class="nav-link active" href="index.php" ><i class="fa fa-fw fa-user-circle"></i>Profile<span class="badge badge-success"></span></a>
                            </li> 
                            <li class="nav-item ">
                                <a class="nav-link" href="#" onclick="toggleFolderIconUser()" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fas fa-folder" id="folderIconUser"></i>Case Folder<span class="badge badge-success">6</span></a>
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
                                <h2 class="pageheader-title"> Dashboard </h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
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
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row align-items-baseline">
                                            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="text-center">
                                                    <img src="assets/images/avatar2.png" alt="User Avatar" class="rounded-circle user-avatar-xxl">
                                                </div>
                                            </div>
                                            <div class="col-xl-10 col-lg-8 col-md-8 col-sm-8 col-12">
                                                <div class="user-avatar-info ">
                                                    <div class="m-b-20 ">
                                                        <div class="user-avatar-name ">
                                                            <h2 class="mb-0">
                                                                <?php 
                                                                /* echo isset($_SESSION['fname']) && isset($_SESSION['lname']) ? $_SESSION['fname'] . ' ' . $_SESSION['lname'] : 'Guest';  */
                                                                echo !empty($data) ? $data['fname'] . ' ' . $data['lname'] : 'Guest';
                                                                ?>
                                                            </h2>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="user-avatar-info ">
                                                    <div class="m-b-20 ">
                                                        <div class="user-avatar-name ">
                                                            <span class="d-xl-inline-block d-block mb-2"><i class="fa fa-map-marker-alt mr-2 text-primary "></i>
                                                                <?php 
                                                                /* echo "Purok " . $data['purok'] . ", Barangay " . $data['barangay'] . ", Buenavista";  */
                                                                echo !empty($data) ? "Purok " . $data['purok'] . ", Barangay " . $data['barangay'] . ", Buenavista" : "Address data not available";
                                                                ?>
                                                            </span>
                                                            <span class="mb-2 ml-xl-4 d-xl-inline-block d-block"><i class="fa fa-phone mr-2 text-primary "></i>
                                                                <?php echo !empty($data['phone_number']) ? $data['phone_number'] : "Phone number not available"; ?>
                                                            </span>
                                                            <span class="mb-2 ml-xl-4 d-xl-inline-block d-block"><i class="fa fa-clock mr-2 text-primary"></i>
                                                                <?php echo !empty($data['dateEntered']) ? $data['dateEntered'] : " Date data not available"; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post" action="server/saveProfileInfo.php" >
                                    <div class="card-body">
                                        <div class="row mb-5 mt-2">
                                            <div class="col">
                                                <h6>HHID Number:</h6>
                                                <p class="hhid">
                                                    <?php echo (!empty($data['hhid']) && strlen($data['hhid']) == 18) ? 
                                                    substr($data['hhid'], 0, 9) . '-' . substr($data['hhid'], 9, 4) . '-' . substr($data['hhid'], 13, 5) : 
                                                    "Data not found!"; ?>
                                                </p>
                                                <input class="form-control form-control-lg hhid" style="display: none;" type="text" pattern="\d{9}-\d{4}-\d{5}" placeholder="HHID number" name="hhid" required autocomplete="off">
                                            </div>
                                            <div class="col">
                                                <h6>First Name:</h6>
                                                <p class="fname">
                                                    <?php echo !empty($data['fname']) ? $data['fname'] : "Data not found!"; ?>
                                                </p>
                                                <input class="form-control form-control-lg fname" style="display: none;" type="text" name="first_name" required placeholder="First Name">
                                            </div>
                                            <div class="col">
                                                <h6>Middle Name:</h6>
                                                <p class="mname">
                                                    <?php echo !empty($data['mname']) ? $data['mname'] : " "; ?>
                                                </p>
                                                <input class="form-control form-control-lg mname" style="display: none;" type="text" name="middle_name" placeholder="Middle Name">
                                            </div>
                                            <div class="col">
                                                <h6>Last Name:</h6>
                                                <p class="lname">
                                                    <?php echo !empty($data['lname']) ? $data['lname'] : "Data not found!"; ?>
                                                </p>
                                                <input class="form-control form-control-lg lname" style="display: none;" type="text" name="last_name" required placeholder="Last Name" autocomplete="username">
                                            </div>
                                            <div class="col">
                                                <h6>Password:</h6>
                                                <p class="password">
                                                <?php echo !empty($data['password']) ? str_repeat('*', $data['password_length']) : "Data not found!"; ?>
                                                </p>
                                                <input class="form-control form-control-lg password" style="display: none;" name="password" type="password" required placeholder="Password" autocomplete="current-password">
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col">
                                                <h6>Phone Number:</h6>
                                                <p class="number">
                                                    <?php echo !empty($data['phone_number']) ? $data['phone_number'] : "Input Information!"; ?>
                                                </p>
                                                <input class="form-control form-control-lg number" style="display: none;" type="text" pattern="[0-9]{11}" title="Please enter a valid 11-digit phone number" name="phone_number" required placeholder="Phone number">
                                            </div>
                                            <div class="col">
                                                <h6>Barangay:</h6>
                                                <p class="barangay">
                                                    <?php echo !empty($data['barangay']) ? $data['barangay'] : "Data not found!"; ?>
                                                </p>
                                                <input class="form-control form-control-lg barangay" style="display: none;" type="text" name="barangay" required placeholder="Barangay">
                                            </div>
                                            <div class="col">
                                                <h6>Purok:</h6>
                                                <p class="purok">
                                                    <?php echo !empty($data['purok']) ? $data['purok'] : "Data not found!"; ?>
                                                </p>
                                                <input class="form-control form-control-lg purok" style="display: none;" type="text" name="purok" required placeholder="Purok">
                                            </div>
                                            <div class="col">
                                                <h6>Set:</h6>
                                                <p class="set">
                                                    <?php echo !empty($data['user_set']) ? $data['user_set'] : "Data not found!"; ?>
                                                </p>
                                                <input class="form-control form-control-lg set" style="display: none;" type="text" name="set" required placeholder="Set">
                                            </div>
                                            <div class="col">
                                                <h6>Phylsis ID number:</h6>
                                                <p class="phylsis_id">
                                                    <?php echo !empty($data['phylsis_id']) ? 
                                                    substr_replace(substr_replace(substr_replace($data['phylsis_id'], '-', 4, 0), '-', 9, 0), '-', 14, 0) : 
                                                    "Input Information!"; ?>
                                                </p>
                                                <input class="form-control form-control-lg phylsis_id" style="display: none;" type="text" pattern="\d{4}-\d{4}-\d{4}-\d{4}" name="phylsis_id" title="Please enter a valid national ID" required placeholder="Phylsis ID number" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <input type="button" class="btn btn-primary" id="editButton" value="Edit">
                                                <input type="submit" class="btn btn-primary" id="saveButton" value="Save" style="display: none;">
                                                <p class="text-center"> **Delete the password before typing the new password**</p>
                                            </div>
                                        </div>
                                    </div>
                                    </form>

                                </div>
                            </div>


                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card" style="overflow-y: auto; overflow-x: auto;">
                                    <div class="card-header">
                                        <div class="row align-items-baseline">
                                            <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-12">
                                                <h2 class="mb-0">Case Folder Summary</h2>      
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr role="row">
                                                            <th style="width: 100px;">Document Type</th>
                                                            <!-- <th style="width: 50px;"># of Document</th> -->
                                                            <th style="width: 200px;">Document Info</th>
                                                            <th style="width: 50px;">Document Status</th>
                                                            <th style="width: 50px;">Document Year</th>
                                                        </tr>
                                                        <tr>
                                                            <!-- Filter row -->
                                                            <th>
                                                                <input type="text" class="form-control" id="filter-type" placeholder="Type Document" />
                                                            </th> 
                                                            <th>
                                                                <input type="text" class="form-control" id="filter-name" placeholder="Type Name" />
                                                            </th>
                                                            <th>
                                                                <select id="filter-status" class="form-control">
                                                                    <option value="">Click to Select</option>
                                                                    <option value="approved">approved</option>
                                                                    <option value="rejected">rejected</option>
                                                                    <option value="pending">pending</option> 
                                                                </select>
                                                            </th>
                                                            <th>
                                                                <input type="text" class="form-control" id="filter-date" placeholder="Type Date" />
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="document-table-body">
                                                        <?php 
                                                        $firstRow = true;
                                                        foreach ($structuredData as $type => $documents): 
                                                            $rowCount = count($documents);
                                                            foreach ($documents as $index => $doc): 
                                                        ?>
                                                        <tr class="document-row" data-type="<?php echo strtolower($type); ?>">
                                                            <?php if ($firstRow): ?>
                                                            <td rowspan="<?php echo $rowCount; ?>" data-rowspan="<?php echo $rowCount; ?>" data-visible="true" class="type-cell" style="background-color: #ffffff;" >
                                                                <?php echo ucfirst(str_replace('_', ' ', $type)); ?>
                                                            </td>
                                                            <?php endif; ?>
                                                            <td class="info-cell">
                                                                <?php 
                                                                    $imgUrl = ($type === 'beneficiary_profile') ? $directories[$type] . $doc['id'] . '&type=view' : (!empty($doc['img']) ? $directories[$type] . htmlspecialchars($doc['img']) : '#');
                                                                ?>
                                                                <a href="<?php echo $imgUrl; ?>" <?php echo !empty($doc['img']) || $type === 'beneficiary_profile' ? 'target="_blank"' : ''; ?>>
                                                                    <?php echo !empty($doc['name']) ? htmlspecialchars($doc['name']) : 'Beneficiary Profile'; ?>
                                                                    <?php if (isset($doc['family_role'])): ?>
                                                                        - <u><?php echo htmlspecialchars($doc['family_role']); ?></u>
                                                                    <?php endif; ?>
                                                                </a>
                                                            </td>
                                                            
                                                            <td class="status-cell">
                                                                <a href="<?php echo $imgUrl; ?>" <?php echo !empty($doc['img']) || $type === 'beneficiary_profile' ? 'target="_blank"' : ''; ?>  style="color: <?php 
                                                                    echo $doc['status'] === 'approved' ? '#28a745' : 
                                                                            ($doc['status'] === 'rejected' ? '#dc3545' : '#007bff');
                                                                ?>; ">
                                                                    <?php echo htmlspecialchars($doc['status']); ?>
                                                                </a>
                                                            </td>
                                                            <td class="date-cell">
                                                                <a href="<?php echo $imgUrl; ?>" <?php echo !empty($doc['img']) || $type === 'beneficiary_profile' ? 'target="_blank"' : ''; ?>>
                                                                    <?php echo htmlspecialchars($doc['upload_date']); ?>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                        $firstRow = false;
                                                        endforeach;
                                                        $firstRow = true;
                                                        endforeach;
                                                        ?>
                                                    </tbody>    
                                                </table>
                                            </div>
                                        </div>            
                                    </div>
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


    // Function to toggle visibility of <p> and <input> elements
    function toggleEdit() {
        var pElements = document.querySelectorAll('p.hhid, p.fname, p.mname, p.lname, p.password, p.number, p.barangay, p.purok, p.set, p.phylsis_id');
        var inputElements = document.querySelectorAll('input.hhid, input.fname, input.mname, input.lname, input.password, input.number, input.barangay, input.purok, input.set, input.phylsis_id');
        var saveButton = document.getElementById('saveButton');

        pElements.forEach(function(pElement, index) {
            pElement.style.display = 'none'; // Hide <p> element
            inputElements[index].style.display = 'block'; // Show <input> element
            inputElements[index].value = pElement.textContent.trim(); // Set input value to current content
        });
        saveButton.style.display = 'block'; 
    }

    // Function to handle click event on Edit button
    document.addEventListener('DOMContentLoaded', function() {
        var editButton = document.getElementById('editButton');
        
        editButton.addEventListener('click', function(event) {
            event.preventDefault();
            toggleEdit(); // Call toggleEdit function to show inputs and hide <p> elements
            editButton.style.display = 'none'; 
        });

        
        // Get DOM elements
        const filterType = document.getElementById('filter-type');
        const filterName = document.getElementById('filter-name');
        const filterStatus = document.getElementById('filter-status');
        const filterDate = document.getElementById('filter-date');
        const tableBody = document.getElementById('document-table-body');

        // Common function to filter rows
        function filterRows() {
            const typeFilter = filterType.value.toLowerCase();
            const nameFilter = filterName.value.toLowerCase();
            const statusFilter = filterStatus.value.toLowerCase();
            const dateFilter = filterDate.value.toLowerCase();
            
            const rows = Array.from(tableBody.getElementsByClassName('document-row'));
            const typeCounts = {};

            // Hide all rows initially
            rows.forEach(row => {
                row.style.display = 'none';
            });

            // Show rows that match all filters
            rows.forEach(row => {
                const type = row.getAttribute('data-type');
                const nameCell = row.querySelector('.info-cell a');
                const statusCell = row.querySelector('.status-cell a');
                const dateCell = row.querySelector('.date-cell a');
                
                const name = nameCell ? nameCell.textContent.toLowerCase() : '';
                const status = statusCell ? statusCell.textContent.toLowerCase() : '';
                const date = dateCell ? dateCell.textContent.toLowerCase() : '';

                const matchesType = type.includes(typeFilter) || typeFilter === '';
                const matchesName = name.includes(nameFilter) || nameFilter === '';
                const matchesStatus = status.includes(statusFilter) || statusFilter === '';
                const matchesDate = date.includes(dateFilter) || dateFilter === '';

                if (matchesType && matchesName && matchesStatus && matchesDate) {
                    row.style.display = '';
                    typeCounts[type] = (typeCounts[type] || 0) + 1;
                }
            });

            // Clear all rowspan attributes initially
            rows.forEach(row => {
                const typeCell = row.querySelector('.type-cell');
                const tempCell = row.querySelector('.temp-cell');
                if (typeCell) {
                    typeCell.removeAttribute('rowspan');
                }
                if (tempCell) {
                    tempCell.removeAttribute('rowspan');
                    tempCell.remove();
                }
            });

            // Apply rowspan for visible rows
            Object.keys(typeCounts).forEach(type => {
                const typeRows = Array.from(tableBody.querySelectorAll(`[data-type="${type}"]`));
                const visibleRows = typeRows.filter(row => row.style.display !== 'none');

                if (visibleRows.length > 0) {
                    const firstVisibleRow = visibleRows[0];
                    let typeCell = firstVisibleRow.querySelector('.type-cell');

                     // If typeCell is null, create a new <td> element
                    if (typeCell === null) {
                        typeCell = document.createElement('td');
                        typeCell.className = 'temp-cell'; // Add the class
                        type = type.replace(/_/g, ' ');
                       // type = type.replace(/\b\w/g, char => char.toUpperCase());
                        type = type.charAt(0).toUpperCase() + type.slice(1);
                        typeCell.textContent = type;

                        firstVisibleRow.insertBefore(typeCell, firstVisibleRow.firstChild); // Insert before the first child
                    } 

                    if (typeCell) {
                        typeCell.setAttribute('rowspan', visibleRows.length);
                    }
                }
            });
        }

        // Attach event listeners to filters
        filterType.addEventListener('input', filterRows);
        filterName.addEventListener('input', filterRows);
        filterStatus.addEventListener('input', filterRows);
        filterDate.addEventListener('input', filterRows);


        /* // Get DOM elements
        const filterType = document.getElementById('filter-type');
        const filterName = document.getElementById('filter-name');
        const filterStatus = document.getElementById('filter-status');
        const filterDate = document.getElementById('filter-date');
        const tableBody = document.getElementById('document-table-body');

        // Common function to filter rows
        function filterRows() {
            const typeFilter = filterType.value.toLowerCase();
            const nameFilter = filterName.value.toLowerCase();
            const statusFilter = filterStatus.value.toLowerCase();
            const dateFilter = filterDate.value.toLowerCase();
            
            const rows = Array.from(tableBody.getElementsByClassName('document-row'));
            const typeCounts = {};

            // Hide all rows initially
            rows.forEach(row => {
                row.style.display = 'none';
            });

            // Show rows that match all filters
            rows.forEach(row => {
                const type = row.getAttribute('data-type');
                const nameCell = row.querySelector('.info-cell a');
                const statusCell = row.querySelector('.status-cell a');
                const dateCell = row.querySelector('.date-cell a');
                
                const name = nameCell ? nameCell.textContent.toLowerCase() : '';
                const status = statusCell ? statusCell.textContent.toLowerCase() : '';
                const date = dateCell ? dateCell.textContent.toLowerCase() : '';

                const matchesType = type.includes(typeFilter) || typeFilter === '';
                const matchesName = name.includes(nameFilter) || nameFilter === '';
                const matchesStatus = status.includes(statusFilter) || statusFilter === '';
                const matchesDate = date.includes(dateFilter) || dateFilter === '';

                if (matchesType && matchesName && matchesStatus && matchesDate) {
                    row.style.display = '';
                    typeCounts[type] = (typeCounts[type] || 0) + 1;
                }
            });

            // Clear all rowspan attributes initially
            rows.forEach(row => {
                const typeCell = row.querySelector('.type-cell');
                if (typeCell) {
                    typeCell.removeAttribute('rowspan');
                }
            });

            // Apply rowspan for visible rows
            Object.keys(typeCounts).forEach(type => {
                const typeRows = Array.from(tableBody.querySelectorAll(`[data-type="${type}"]`));
                const visibleRows = typeRows.filter(row => row.style.display !== 'none');

                if (visibleRows.length > 0) {
                    const firstVisibleRow = visibleRows[0];
                    const typeCell = firstVisibleRow.querySelector('.type-cell');

                    if (typeCell) {
                        typeCell.setAttribute('rowspan', visibleRows.length);
                    }
                }
            });
        }

        // Attach event listeners to filters
        filterType.addEventListener('input', filterRows);
        filterName.addEventListener('input', filterRows);
        filterStatus.addEventListener('input', filterRows);
        filterDate.addEventListener('input', filterRows);

        // Initial call to apply any default filters if present
        filterRows(); */

    });



    </script>
</body>
 
</html>