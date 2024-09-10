<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: pages/login.php");
    exit;
}

require_once 'server/display/pendoc_display.php';
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
    <!-- <link rel="stylesheet" href="assets/vendor/charts/c3charts/c3.css"> -->
    <title> Pending User Documents </title>
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .cursor-pointer:hover {
            opacity: 0.7;
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
                                <input id="global-search" class="form-control" type="text" placeholder="Search Document ...">
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
                                <a class="nav-link" href="index.php"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Chart.php"><i class="fas fa-fw fa-chart-pie"></i>Chart</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="Reports.php"><i class="fab fa-fw fa-wpforms"></i>Reports</a>
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
                                <a class="nav-link active" href="pendingDocs.php">
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
                                <h2 class="pageheader-title"> Pending Documents </h2>
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
                            <?php foreach ($docGroups as $doctype => $docs): ?>
    <?php if (array_key_exists($doctype, $docTypeMap)): ?>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 document-card">
            <div class="card">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0" style="color: aliceblue;"><?php echo htmlspecialchars($docTypeMap[$doctype]); ?></h5>
                        <p>Pending Documents</p>
                    </div>
                    <div class="dropdown d-flex">
                        <input class="form-control w-150" name="search" type="text" placeholder="Search Name or HHID">
                    </div>
                </div>
                <div class="card-body">
                    <div style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
                        <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example" class="table table-striped table-bordered second dataTable" style="width: 100%;" role="grid" aria-describedby="example_info">
                                        <thead>
                                            <tr role="row">
                                                <th style="width: 100px;">Name</th>
                                                <th style="width: 100px;">HHID</th>
                                                <th style="width: 100px;">Documents</th>
                                                <th style="width: 100px;">Remarks</th>
                                                <th style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($docs as $doc): ?>
                                                <tr role="row" class="odd">
                                                    <td class="sorting_1"><?php echo htmlspecialchars($doc['fname'] . ' ' . $doc['mname'] . ' ' . $doc['lname']); ?></td>
                                                    <td><?php echo formatHhid(htmlspecialchars($doc['hhid'])); ?></td>
                                                    <?php
                                                        // Display image if available
                                                        if (!empty($doc['img'])) {

                                                            $filePath = $docDirectory[$doctype] . $doc['img'];
                                                            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

                                                            $icon = '<i class="fas fa-file-alt fa-sm text-light"></i>';
                                                            $link = "<a href='{$filePath}' target='_blank' class='icon-box-md cursor-pointer'>{$icon}</a>";

                                                            if ($extension == 'pdf') {
                                                                echo "<td class='text-center'><span class='badge badge-info'>{$link}</span></td>";
                                                            } elseif (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                                                echo "<td class='text-center'><span class='badge badge-info'>{$link}</span></td>";
                                                            } else {
                                                                echo "<td class='text-center'><span class='badge badge-info'>{$link}</span></td>";
                                                            }
                                                        } else {
                                                            if($docTypeMap[$doctype] === 'Beneficiary Profile') {
                                                                $filePathB = $docDirectory[$doctype] . $doc['id'] . '&type=view';
                                                                $iconB = '<i class="fas fa-file-alt fa-sm text-light"></i>';
                                                                $linkB = "<a href='{$filePathB}' target='_blank' class='icon-box-md cursor-pointer'>{$iconB}</a>";
                                                                echo "<td class='text-center'><span class='badge badge-info'>{$linkB}</span></td>"; // change pani
                                                            } else {
                                                                echo "<td class='text-center'></td>";
                                                            }
                                                        }
                                                    ?>
                                                    <td class="text-center">
                                                        <span class="badge badge-info icon-box-md  pr-5">
                                                            <i class="fas fa-comment fa-sm ml-2 text-light cursor-pointer" data-toggle='modal' data-target='#remForm' 
                                                                data-user-name="<?php echo htmlspecialchars($doc['fname'] . ' ' . $doc['mname'] . ' ' . $doc['lname']); ?>" 
                                                                data-user-id="<?php echo htmlspecialchars($doc['acc_id']); ?>" data-doc-type="<?php echo htmlspecialchars($docTypeMap[$doctype]); ?>"
                                                                data-id="<?php echo htmlspecialchars($doc['id']); ?>" data-remarks="<?php echo htmlspecialchars($doc['remarks']); ?>"></i>
                                                        </span>
                                                    </td>
                                                    <td class="d-flex justify-content-around">
                                                        <!-- Check if image is available to enable/disable buttons -->
                                                        <?php
                                                            // Determine if buttons should be enabled or disabled
                                                            $isDisabled = empty($doc['img']) && $docTypeMap[$doctype] !== 'Beneficiary Profile';
                                                        ?>
                                                        <button class="btn btn-primary" <?php echo $isDisabled ? 'disabled' : ''; ?> 
                                                            data-toggle='modal' data-target='#appForm' data-user-name="<?php echo htmlspecialchars($doc['fname'] . ' ' . $doc['mname'] . ' ' . $doc['lname']); ?>" 
                                                            data-user-id="<?php echo htmlspecialchars($doc['acc_id']); ?>" data-doc-type="<?php echo htmlspecialchars($docTypeMap[$doctype]); ?>"
                                                            data-id="<?php echo htmlspecialchars($doc['id']); ?>">Approved</button>

                                                        <button class="btn btn-danger" <?php echo $isDisabled ? 'disabled' : ''; ?> 
                                                            data-toggle='modal' data-target='#rejForm' data-user-name="<?php echo htmlspecialchars($doc['fname'] . ' ' . $doc['mname'] . ' ' . $doc['lname']); ?>" 
                                                            data-user-id="<?php echo htmlspecialchars($doc['acc_id']); ?>" data-doc-type="<?php echo htmlspecialchars($docTypeMap[$doctype]); ?>"
                                                            data-id="<?php echo htmlspecialchars($doc['id']); ?>">Reject</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>





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
        <div class="modal fade" id="appForm" tabindex="-1" role="dialog" aria-labelledby="idFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idFormLabel">Document Approval</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="approvalForm" action="server/update/appdoc_update.php" method="post">
                        <div class="modal-body text-center">
                            <div class="form-group">
                                <p>Confirm approval for the document of <span id="userName" class="text-danger"></span>?</p>
                                <input type="hidden" id="userId" name="userId" value="">     
                                <input type="hidden" id="docType" name="docType" value="">     
                                <input type="hidden" id="docId" name="docId" value="">                     
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-around pt-2 pb-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="rejForm" tabindex="-1" role="dialog" aria-labelledby="idFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idFormLabel">Document Rejection</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="server/update/rejdoc_update.php" method="post">
                        <div class="modal-body text-center">
                            <div class="form-group">
                                <p>Confirm rejection for the document of <span id="userNameRej" class="text-danger"></span>?</p>
                                <input type="hidden" id="userIdRej" name="userIdRej" value="">   
                                <input type="hidden" id="docTypeRej" name="docTypeRej" value="">    
                                <input type="hidden" id="docIdRej" name="docIdRej" value="">                         
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-around pt-2 pb-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="remForm" tabindex="-1" role="dialog" aria-labelledby="idFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="idFormLabel">Document Remarks</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="server/update/remdoc_update.php" method="post">
                        <div class="modal-body text-center">
                            <div class="form-group">
                                <h4>Create Message for <span id="userNameRem" class="text-danger"></span></h4>
                                <textarea class="form-control" name="msg" id="remarks" cols="60" rows="4"></textarea>
                                <input type="hidden" id="userIdRem" name="userIdRem" value="">
                                <input type="hidden" id="docTypeRem" name="docTypeRem" value=""> 
                                <input type="hidden" id="docIdRem" name="docIdRem" value="">                                    
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-around pt-2 pb-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
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
    <!-- slimscroll js -->
    <!-- <script src="assets/vendor/slimscroll/jquery.slimscroll.js"></script> -->
    <!-- main js -->
    <!-- <script src="assets/libs/js/main-js.js"></script> -->

    <script>

        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = 'server/logout.php';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
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
            // When the modal is about to be shown
            $('#appForm').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var userId = button.data('user-id'); // Extract info from data-* attributes
                var userName = button.data('user-name');
                var docType = button.data('doc-type');
                var docId = button.data('id');

                // Update the userIdInput value
                $('#userId').val(userId);
                $('#userName').text(userName);
                $('#docType').val(docType);
                $('#docId').val(docId);

            });

            $('#rejForm').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var userId = button.data('user-id'); // Extract info from data-* attributes
                var userName = button.data('user-name');
                var docType = button.data('doc-type');
                var docId = button.data('id');

                // Update the userIdInput value
                $('#userIdRej').val(userId);
                $('#userNameRej').text(userName);
                $('#docTypeRej').val(docType);
                $('#docIdRej').val(docId);
            });

            $('#remForm').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var userId = button.data('user-id'); // Extract info from data-* attributes
                var userName = button.data('user-name');
                var docType = button.data('doc-type');
                var docId = button.data('id');
                var remarks = button.data('remarks');

                // Update the userIdInput value
                $('#userIdRem').val(userId);
                $('#userNameRem').text(userName);
                $('#docTypeRem').val(docType);
                $('#docIdRem').val(docId);
                $('#remarks').text(remarks);
            });


            // Handle search input
            $('.form-control').on('input', function() {
                var searchTerm = $(this).val().toLowerCase();
                var $table = $(this).closest('.card').find('table');
                var $rows = $table.find('tbody tr');
                
                $rows.each(function() {
                    var name = $(this).find('td').eq(0).text().toLowerCase();
                    var hhid = $(this).find('td').eq(1).text().toLowerCase();
                    if (name.includes(searchTerm) || hhid.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }); 


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