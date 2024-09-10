<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: pages/login.php");
    exit;
}
require_once 'server/display/dynamic_display.php';
require_once 'server/display/ncsearch_display.php';
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
    <title> Admin Search </title>
</head>
    <style>
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
        .full-page-modal {
            display: none; 
            position: fixed; 
            z-index: 99999; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
    </style>

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
                                <a class="nav-link" href="Reports.php"><i class="fab fa-fw fa-wpforms"></i>Reports</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="Search.php"><i class="fas fa-search"></i>All Documents</a>
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
                                <h2 class="pageheader-title"> Dashboard </h2>
                                <div class="pills-regular pb-2 pt-3 border-top">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item mr-3">
                                            <a href="Search.php" class="btn btn-primary">Admin</a>
                                        </li>
                                        <li class="nav-item mr-3">
                                            <a href="comsearch.php" class="btn btn-success">Exited</a>
                                        </li>
                                        <li class="nav-item mr-3">
                                            <a href="acsearch.php" class="btn btn-danger">Active</a>
                                        </li>
                                        <li class="nav-item mr-3">
                                            <a href="ncsearch.php" class="btn btn-warning">Non Compliance</a>
                                        </li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <div class="ecommerce-widget" >
              
                        <div class="row content " id="complianceTable">
                            
                        <?php foreach ($data as $barangay => $households): ?> 
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 document-card">
        <div class="card">
            <div class="card-header bg-warning d-flex justify-content-between align-items-center">
                <div class="div">
                    <h5 class="mb-0" style="color: aliceblue;"><?php echo htmlspecialchars($barangay); ?></h5>
                </div>
                <div class="dropdown d-flex">
                    <a class="btn btn-light mr-3" href='print_ncsearch.php?barangay=<?php echo urlencode($barangay); ?>' target="_blank"><i class="fas fa-print text-dark"> Print</i></a>
                    <input class="form-control w-150" name="search" type="text" placeholder="Search Name or HHID">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example" class="table table-striped table-bordered second dataTable" style="width: 100%;" role="grid" aria-describedby="example_info">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 130px;">Name</th>
                                            <th style="width: 130px;">HHID</th>
                                            <th style="width: 30px;">Number</th>
                                            <th style="width: 70px;">Set</th>
                                            <th style="width: 70px;">Purok</th>
                                            <th style="width: 150px;">Missing Data</th>
                                            <th style="width: 150px;">Present Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($households as $householdName => $rows): 
                                        // Extract name and HHID from $householdName
                                        preg_match('/^(.*)\s\((\d+)\)$/', $householdName, $matches);
                                        $name = $matches[1] ?? 'N/A'; // Default to 'N/A' if name is not found
                                        $hhid = $matches[2] ?? 'N/A'; // Default to 'N/A' if HHID is not found
                                       /*  $accId = $matches[3] ?? 'N/A';  preg_match('/^(.*)\s\((\d+)\)\s(\d+)$/', $householdName, $matches); */

                                        // Handle 'no_data' which might be an array or a string
                                        if (is_array($rows['no_data'])) {
                                            // Convert array to a comma-separated string
                                            $no_data_string = implode(', ', $rows['no_data']);
                                        } else {
                                            // Use the existing string
                                            $no_data_string = $rows['no_data'];
                                        }
                                        // Handle 'has_data' which might be an array or a string
                                        if (is_array($rows['has_data'])) {
                                            // Convert array to a comma-separated string
                                            $has_data_string = implode(', ', $rows['has_data']);
                                        } else {
                                            // Use the existing string
                                            $has_data_string = $rows['has_data'];
                                        }

                                        // Replace commas with <br> for line breaks and escape HTML
                                        $no_data = str_replace(', ', '<br>', $no_data_string);
                                        $has_data = str_replace(', ', '<br>', $has_data_string);
                                        /* $no_data = htmlspecialchars($no_data); */
                                        
                                    ?>
                                        <tr role="row" class="odd">
                                            <td><?php echo htmlspecialchars($name); ?></td>
                                            <td><?php echo formathhid(htmlspecialchars($hhid)); ?></td>
                                            <td><?php echo htmlspecialchars($rows['phone_number']); ?></td>
                                            <td><?php echo htmlspecialchars($rows['user_set']); ?></td>
                                            <td><?php echo htmlspecialchars($rows['purok']); ?></td>
                                            <td><?php echo $no_data; ?></td>
                                            <td>
                                                <a href="#" data-toggle='modal' data-target='#view_doc' data-hhid="<?php echo htmlspecialchars($hhid); ?>" data-name="<?php echo htmlspecialchars($name); ?>" >
                                                    <?php echo $has_data; ?>
                                                </a>
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
<?php endforeach; ?>

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
        <!-- View Document Modal -->
        <div id="view_doc" class="full-page-modal">
            <div class="modal-content">
                <div class="text-right">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                                               
                </div>
                <input type="text" id="user_hhid" name="user_hhid" style="display:none;">
                <h4 class="text-center">User: <u><span id="user_name"></span></u></h4>
                <div id="doc-container" class="upper-front">
                <!-- Content will be loaded here  -->
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

            $('#view_doc').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var hhid = button.data('hhid'); // Extract info from data-* attributes
                var name = button.data('name');

                // Update the userIdInput value
                $('#user_hhid').val(hhid);
                $('#user_name').text(name);

                // Perform an AJAX request to fetch images based on hhid
                $.ajax({
                    url: 'server/fetch_data/docs.php',
                    method: 'POST',
                    data: { user_hhid: hhid },
                    success: function(response) {
                        // Assuming `response` contains the HTML of images
                        $('#doc-container').html(response);
                    },
                    error: function() {
                        $('#doc-container').html('<p>Failed to load images.</p>');
                    }
                });

            });


        });

    </script>

</body>
 
</html>