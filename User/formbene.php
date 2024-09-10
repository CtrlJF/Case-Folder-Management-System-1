<?php
session_start();

// Check if the user is not logged in, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: pages/login.php");
    exit;
}

require_once 'server/displays/frmbene_display.php';
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
    <title> Form Beneficiary Profile </title>

    <style>
        .col-sm-5 .form-control{
            border: none;
            border-bottom: 1px solid  #71748d;
            padding-bottom: 0;
           transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        .col-sm-5 .form-control:focus {
            outline: 0;
            box-shadow: none;
            border-color: #80bdff;
        }
        td .form-control {
            border: none;
        }
        td .form-control:focus {
            outline: 0;
            box-shadow: none;
        }

        .table-wrapper {
            overflow-x: auto; /* Enable horizontal scrolling */
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on touch devices */
        }

        .underline {
            border: none;
            border-bottom: 1px solid #71748d; /* Underline color */
            background: transparent;
            resize: none; /* Prevent resizing */
            width: 100%; /* Full width of the container */
            font-size: 16px;
            padding: 5px 0; /* Space above and below the text */
            outline: none;
        }
        .underline:focus {
            box-shadow: none;      
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
                                            <a class="nav-link" href="cashCard.php">Cash Card</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="familyPicture.php">Family Picture</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="kasabutan.php">Kasabutan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="birthCert.php">Birth Certificate</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="marriageCont.php">Marriage Contract</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="immuRec.php">Immunization Record</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="gradeCards.php">Grade Cards</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="mdr.php">MDR</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="CertAttendance.php">Certificate of Attendance on Trainings Attended</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="beneProfile.php">Beneficiary Profile</a>
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
                                <h2 class="pageheader-title">Beneficiary Profile Form</h2>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="beneprofile.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a></li>
                                            
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
                                <div class="row" id="parent-row">

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="product-thumbnail">
                                                <form action="server/create/bene_create.php" method="post" onsubmit="return validateForm()">
                                                <div class="title p-3 mt-4">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-6">
                                                            <div class="text-center">
                                                                <div>Department of Social Welfare and Development</div>
                                                                <div>Pantawid Pamilyang Pilipino Program</div>
                                                                <div>BENEFICIARY PROFILE</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="head-form">
                                                <div class="head-1 mt-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row">
                                                                <label for="probinsya" class="col-sm-2 form-label">Probinsya:</label>
                                                                <div class="col-sm-5 ">
                                                                    <input type="text" class="form-control" id="probinsya" name="probinsya" required value="Agusan Del Norte" > <!-- Placeholder="Ex. Agusan Del Norte" -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="lungsod">Lungsod:</label>
                                                                <div class="col-sm-5 ">
                                                                    <input type="text" class="form-control " id="" name="lungsod" required value="Buenavista" ><!-- Placeholder="Ex. Buenavista" -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="barangay">Barangay:</label>
                                                                <div class="col-sm-5">
                                                                    <input type="text" class="form-control " id="" name="barangay" required value="<?php echo !empty($data) ? htmlspecialchars($data['barangay']) : 'Enter Barangay'; ?>" > <!-- placeholder="Enter Barangay" -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="purok">Purok/Street:</label>
                                                                <div class="col-sm-5 ml-4">
                                                                    <input type="text" class="form-control underline-adjust " id="" name="purok" required value="<?php echo !empty($data) ? htmlspecialchars('Purok ' . $data['purok']) : 'Enter Purok'; ?>" > <!-- placeholder="Enter Purok" -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="head-2 ">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="hhid">Household ID:</label>
                                                                <div class="col-sm-5 ml-4">
                                                                    <input type="text" class="form-control" pattern="\d{9}-\d{4}-\d{5}" id="" name="hhid"  required value="<?php echo (!empty($data['hhid']) && strlen($data['hhid']) == 18) ? 
                                                                        substr($data['hhid'], 0, 9) . '-' . substr($data['hhid'], 9, 4) . '-' . substr($data['hhid'], 13, 5) : 
                                                                        "Enter HHID"; ?>" > <!-- placeholder="Ex. 000000000-0000-0000" -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="memtribe">Membro sa Tribo:</label>
                                                                <div class="col-sm-5 ml-5">
                                                                    <!-- <input type="text" class="form-control underline-adjust" id="" name="memtribe" > -->
                                                                    <label>
                                                                        Oo
                                                                        <input class="mr-2" type="checkbox" name="option1" value="Oo">
                                                                    </label>
                                                                    <label>
                                                                        Dli
                                                                        <input type="checkbox" name="option1" value="Dli">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="nametribe">Pangalan sa Tribo:</label>
                                                                <div class="col-sm-5 ml-5">
                                                                    <input type="text" class="form-control underline-adjust" id="" name="nametribe" required placeholder="Enter Tribe Name ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="relihiyon">Relihiyon:</label>
                                                                <div class="col-sm-5">
                                                                    <input type="text" class="form-control " id="" name="relihiyon" required placeholder="Enter Religion ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label mr-5" for="numlivehouse"># of Familis living in HH:</label>
                                                                <div class="col-sm-5 ml-5">
                                                                    <input type="number" class="form-control underline-adjust" id="" name="numlivehouse" required placeholder="Enter a Number ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="head-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="philhealth">Philhealth:</label>
                                                                <div class="col-sm-5 d-flex">
                                                                    <!-- <input type="text" class="form-control " id="" name="philhealth" > -->
                                                                    <label>
                                                                        Naa
                                                                        <input class="mr-2" type="checkbox" name="option" value="Naa">
                                                                    </label>
                                                                    <label>
                                                                        Wala
                                                                        <input type="checkbox" name="option" value="Wala">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="grant">Grant:</label>
                                                                <div class="col-sm-5 d-flex">
                                                                    <!-- <input type="text" class="form-control " id="" name="grant" > -->
                                                                    <label>
                                                                        OTC
                                                                        <input class="mr-2" type="checkbox" name="option2" value="OTC" >
                                                                    </label>
                                                                    <label>
                                                                        Cash Card
                                                                        <input class="mr-2" type="checkbox" name="option2" value="Cash Card" >
                                                                    </label>
                                                                    <label>
                                                                        G-Remit
                                                                        <input type="checkbox" name="option2" value="G-Remit" >
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="accnum">Account #:</label>
                                                                <div class="col-sm-5 ml-2">
                                                                    <input type="text" class="form-control " id="" name="accnum" required placeholder="Enter Account Number ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="hhstat">HH Status:</label>
                                                                <div class="col-sm-5 ml-2">
                                                                    <input type="text" class="form-control " id="" name="hhstat" required placeholder="Enter HouseHold Status ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0 p-0 row ">
                                                                <label class="col-sm-2 col-form-label" for="dailyincome">Daily Income:</label>
                                                                <div class="col-sm-5 ml-3">
                                                                    <input type="number" class="form-control underline-adjust" id="" name="dailyincome" step="0.01" min="0" placeholder="0.00" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                


                                                <div class="body mt-5">
                                                    <div class="container mt-4 table-wrapper">
                                                        <div class="row justify-content-center">
                                                            <div class="col-md-6">
                                                                <div class="text-center">
                                                                    <div>MEMBRO SA HOUSEHOLD</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <thead >
                                                                <tr >
                                                                    <th class="pb-5" >No.</th>
                                                                    <th class="pb-5 pl-4 pr-4">Apilyedo</th>
                                                                    <th class="pb-5 pl-4 pr-4">Pangalan</th>
                                                                    <th class="pb-5 pl-4 pr-4">Middle Name</th>
                                                                    <th class="pb-4 pl-4 pr-4">Birthday (YYYY-MM-DD)</th>
                                                                    <th class="pb-5 pl-4 pr-4">Sex/Gender</th>
                                                                    <th class="pb-4 pl-4 pr-4">Relasyon sa Pamilya</th>
                                                                    <th class="pb-5 pl-4 pr-4">Civil Status</th>
                                                                    <th class="pb-4 pl-4 pr-4">Buntis (Oo or Dli)</th>
                                                                    <th class="pb-3 pl-4 pr-4">Nag eskwela (Oo or Dli)</th>
                                                                    <th class="pb-5 pl-4 pr-4">Grado</th>
                                                                    <th class="pb-2 pl-4 pr-4">Na Rehistro nga Grantee (Oo or Dli)</th>
                                                                    <th class="pb-5 pl-4 pr-4">Panginabuhi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- Generate 15 rows of data -->
                                                                <?php for($i = 1; $i <= 15; $i++): ?>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $i; ?></td>
                                                                        <td><input type="text" class="form-control" name="lname_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="fname_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="mname_<?php echo $i; ?>"></td>
                                                                        <td><input type="date" class="form-control" name="birthday_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="gender_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="family_relation_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="civil_status_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="buntis_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="school_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="grade_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="register_grantee_<?php echo $i; ?>"></td>
                                                                        <td><input type="text" class="form-control" name="work_living_<?php echo $i; ?>"></td>
                                                                    </tr>
                                                                <?php endfor; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>










                                                
                                                <div class="foot mb-5">
                                                    <div class="container table-wrapper">
                                                        <table class="table table-bordered">
                                                            <div class="col-sm-7 pl-0 mt-5"><strong>NADAWAT NGA CASH GRANT</strong></div>   
                                                            <thead >
                                                                <tr ><!-- class="d-flex justify-content-center align-items-center text-center" -->
                                                                    <th class="pb-3">TUIG.</th>
                                                                    <th>DEC-JAN</th>
                                                                    <th>FEB-MAR</th>
                                                                    <th>APR-MAY</th>
                                                                    <th>JUN-JUL</th>
                                                                    <th>AUG-SEPT</th>
                                                                    <th>OCT-NOV</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                    // Get the current year
                                                                    $currentYear = date('Y');
                                                                    // Define the range of years you want to display
                                                                    $startYear = $currentYear - 2; // 2 years before the current year
                                                                    $endYear = $currentYear + 2;   // 3 years after the current year

                                                                    // Generate rows
                                                                    for ($year = $startYear; $year <= $endYear; $year++):
                                                                ?>
                                                                <tr>
                                                                    <td class="text-center"> <?php echo $year; ?> </td>
                                                                    <td><input type="number" class="form-control" name="dec-jan_<?php echo $year; ?>"> </td>
                                                                    <td><input type="number" class="form-control" name="feb-mar_<?php echo $year; ?>"> </td>
                                                                    <td><input type="number" class="form-control" name="apr-may_<?php echo $year; ?>"> </td>
                                                                    <td><input type="number" class="form-control" name="june-jul_<?php echo $year; ?>"> </td>
                                                                    <td><input type="number" class="form-control" name="aug-sept_<?php echo $year; ?>"> </td>
                                                                    <td><input type="number" class="form-control" name="oct-nov_<?php echo $year; ?>"> </td>
                                                                </tr>
                                                                <?php endfor; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>  
                                                    <div class="container">
                                                        <div class="col-sm-7 pl-0 mt-5"><strong>GI-UNSA PAG GAMIT ANG KWARTA:</strong></div>
                                                        <textarea class="underline pl-2" name="cash-use-1" maxlength="58" rows="1" required></textarea>
                                                        <textarea class="underline pl-2" name="cash-use-2" maxlength="58" rows="1" ></textarea>
                                                        <textarea class="underline pl-2" name="cash-use-3" maxlength="58" rows="1" ></textarea>
                                                        <textarea class="underline pl-2" name="cash-use-4" maxlength="58" rows="1" ></textarea>
                                                    </div>          
                                                </div>                        






                                                    <div class="text-center">                   
                                                        <button type="submit" class="btn btn-primary">Submit</button> 
                                                    </div>                    
                                                </form>
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
    
   

    <script>
    function handleFileSelect(event) {
        const selectedFile = event.target.files[0];
        if (selectedFile) {
            // Process the selected file here
            console.log("Selected file:", selectedFile);
        }
    }

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

    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="option"]');
        const checkboxes1 = document.querySelectorAll('input[type="checkbox"][name="option1"]');
        const checkboxes2 = document.querySelectorAll('input[type="checkbox"][name="option2"]');
            
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                        }
                    });
                }
            });
        });
        checkboxes1.forEach(checkbox1 => {
            checkbox1.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes1.forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                        }
                    });
                }
            });
        });
        checkboxes2.forEach(checkbox2 => {
            checkbox2.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes2.forEach(cb => {
                        if (cb !== this) {
                            cb.checked = false;
                        }
                    });
                }
            });
        });

    });

        function validateForm() {
            // Select checkboxes for each group
            var option1Checkboxes = document.querySelectorAll('input[name="option1"]');
            var optionCheckboxes = document.querySelectorAll('input[name="option"]');
            var option2Checkboxes = document.querySelectorAll('input[name="option2"]');

            // Function to check if at least one checkbox is checked
            function isAnyChecked(checkboxes) {
                return Array.from(checkboxes).some(checkbox => checkbox.checked);
            }

            // Check if at least one checkbox is checked in each group
            var isOption1Checked = isAnyChecked(option1Checkboxes);
            var isOptionChecked = isAnyChecked(optionCheckboxes);
            var isOption2Checked = isAnyChecked(option2Checkboxes);

            // Show alerts if any group is not checked
            if (!isOption1Checked) {
                alert('Please select at least one option for "Membro sa Tribo".');
                return false; // Prevent form submission
            }
            if (!isOptionChecked) {
                alert('Please select at least one option for "Philhealth".');
                return false; // Prevent form submission
            }
            if (!isOption2Checked) {
                alert('Please select at least one option for "Grant".');
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

    </script>
</body>
 
</html>