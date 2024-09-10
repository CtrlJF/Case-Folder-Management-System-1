<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: pages/login.php");
    exit;
}

if (!isset($_SESSION['alert_shown']) || $_SESSION['alert_shown'] === false) {

    echo "<script>alert('Welcome, " . 
    (!empty($_SESSION['fname']) && !empty($_SESSION['lname']) 
        ? $_SESSION['fname'] . " " . $_SESSION['lname'] 
        : "Guest") . 
    "!');</script>";

    $_SESSION['alert_shown'] = true;
}

require_once 'server/display/dashboard_display.php';
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
    <title> Dashboard </title>
    
    <style>
        .btn-group {
            display: flex;
            gap: 0.3rem; /* Adjust spacing between buttons */
        }
        #notificationBackdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); 
            z-index: 999999; 
            display: none; 
        }
        #welcomeNotification {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 50px 60px;
            background-color: #28a745; /* Green background */
            color: white; 
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            opacity: 1;
            transition: opacity 1s ease-out;
            z-index: 1000000;
            text-align: center; 
        }
        #welcomeNotification.fade-out {
            opacity: 0;
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
                                <a class="nav-link active" href="index.php"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
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
                                <a class="nav-link" href="dropgrantee.php"><i class="fa fa-check-circle"></i>Drop Grantee</i></a>
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
                            <?php
                            // Fetch all data
                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            // Initialize an array to group users by barangay
                            $barangayGroups = [];
                            // Group users by barangay and count statuses
                            foreach ($data as $row) {
                                $barangay = $row['barangay'];
                                $status = $row['status'];
                                
                                if (!isset($barangayGroups[$barangay])) {
                                    $barangayGroups[$barangay] = [];
                                    $barangayStatusCounts[$barangay] = [
                                        'completed' => 0,
                                        'inactive' => 0,
                                        'active' => 0
                                    ];
                                }

                                $barangayGroups[$barangay][] = $row;

                                // Count status occurrences
                                if (isset($barangayStatusCounts[$barangay][$status])) {
                                    $barangayStatusCounts[$barangay][$status]++;
                                }
                            }
                            ?>
<?php foreach ($barangayGroups as $barangay => $users): ?>
    <?php
    // Generate a unique ID for the pie chart and for the button group
    $pieChartId = 'pieChart_' . str_replace(' ', '_', strtolower($barangay));
    $btnGroupId = 'btnGroup_' . str_replace(' ', '_', strtolower($barangay));
    $searchId = 'search_' . str_replace(' ', '_', strtolower($barangay));
    $barangayCardId = 'barangayCard_' . str_replace(' ', '_', strtolower($barangay));

    // Calculate total counts
    $total = $barangayStatusCounts[$barangay]['completed'] + $barangayStatusCounts[$barangay]['inactive'] + $barangayStatusCounts[$barangay]['active'];

    // Calculate percentages
    $completedPercent = ($total > 0) ? ($barangayStatusCounts[$barangay]['completed'] / $total) * 100 : 0;
    $inactivePercent = ($total > 0) ? ($barangayStatusCounts[$barangay]['inactive'] / $total) * 100 : 0;
    $activePercent = ($total > 0) ? ($barangayStatusCounts[$barangay]['active'] / $total) * 100 : 0;

    ?>
    <div id="<?php echo $barangayCardId; ?>" class="barangay-card col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?php echo htmlspecialchars($barangay); ?></h5>
                <div class="d-flex">
                    <input id="<?php echo $searchId; ?>" class="form-control w-50" name="search" type="text" placeholder="Search Name or HHID">
                    <div id="<?php echo $btnGroupId; ?>" class="btn-group ml-3">
                        <button type="button" class="btn btn-danger" data-status="active">Active</button>
                        <button type="button" class="btn btn-success" data-status="completed">Exited</button>
                        <button type="button" class="btn btn-warning" data-status="inactive">Inactive</button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto; overflow-x: auto;">
                    <table class="table">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th class="border-0">#</th>
                                <!-- <th class="border-0">Profile</th> -->
                                <th class="border-0" style="width: 200px;">Full Name</th>
                                <th class="border-0">HHID Number</th>
                                <th class="border-0">Set</th>
                                <th class="border-0">Purok</th>
                                <th class="border-0">Number</th>
                                <th class="border-0">Philsis ID</th>
                                <th class="border-0">Grantees</th>
                                <th class="border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user): ?>
                                <?php
                                // Determine the badge class based on the user's status
                                $badgeClass = '';
                                switch ($user['status']) {
                                    case 'inactive':
                                        $badgeClass = 'badge-brand';
                                        $userStatus = $user['status'];
                                        break;
                                    case 'active':
                                        $badgeClass = 'badge-danger';
                                        $userStatus = $user['status'];
                                        break;
                                    case 'completed':
                                        $badgeClass = 'badge-success';
                                        $userStatus = 'exited';
                                        break;
                                    default:
                                        $badgeClass = 'badge-secondary'; 
                                        $userStatus = $user['status'];     // Default class if status is unknown
                                }
                                ?>
                                <tr data-status="<?php echo htmlspecialchars($user['status']); ?>" data-hhid="<?php echo htmlspecialchars($user['hhid']); ?>">
                                    <td><?php echo ($index + 1); ?></td>
                                    <td><?php echo htmlspecialchars($user['fname']) . ', ' . htmlspecialchars($user['mname']) . ' ' . htmlspecialchars($user['lname']); ?></td>
                                    <td><?php echo formatHhid(htmlspecialchars($user['hhid'])); ?></td>
                                    <td><?php echo htmlspecialchars($user['user_set']); ?></td>
                                    <td><?php echo htmlspecialchars($user['purok']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                                    <td><?php echo formatid(htmlspecialchars($user['phylsis_id'])); ?></td>
                                    <td><?php echo htmlspecialchars($user['count_18_or_older']) . '/' . htmlspecialchars($user['total_Oo']); ?></td>
                                    <td><span class="badge-dot <?php echo $badgeClass; ?> mr-1"></span><?php echo htmlspecialchars($userStatus); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
        <div class="card">
            <h5 class="card-header">Color Pie for <?php echo htmlspecialchars($barangay); ?></h5>
            <div class="card-body">
                <div id="<?php echo $pieChartId; ?>"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize pie chart
            if (document.getElementById("<?php echo $pieChartId; ?>")) {
                var chart = c3.generate({
                    bindto: "#<?php echo $pieChartId; ?>",
                    data: {
                        columns: [
                            ["exited", <?php echo $completedPercent; ?>],
                            ["inactive", <?php echo $inactivePercent; ?>],
                            ["active", <?php echo $activePercent; ?>]
                        ],
                        type: "pie",
                        colors: {
                            active: "red",
                            inactive: "orange",
                            exited: "green"
                        }
                    },
                    pie: {
                        label: {
                            format: function(value, ratio, id) {
                                return d3.format(".2%")(ratio);
                            }
                        }
                    }
                });
            }

            // Button click handlers
            var btnGroups = document.querySelectorAll('.btn-group');
            btnGroups.forEach(function(btnGroup) {
                btnGroup.addEventListener('click', function(e) {
                    var target = e.target;
                    if (target.tagName === 'BUTTON') {
                        var status = target.getAttribute('data-status');
                        var cardBody = btnGroup.closest('.card').querySelector('.table tbody');
                        var rows = cardBody.querySelectorAll('tr');
                        rows.forEach(function(row) {
                            if (status === 'all' || row.getAttribute('data-status') === status) {
                                row.style.display = ''; // Show row
                            } else {
                                row.style.display = 'none'; // Hide row
                            }
                        });
                    }
                });
            });

            // Search functionality
            var searchInputs = document.querySelectorAll('.form-control');
            searchInputs.forEach(function(searchInput) {
                searchInput.addEventListener('input', function() {
                    var searchTerm = this.value.toLowerCase();
                    var cardBody = searchInput.closest('.card').querySelector('.table tbody');
                    var rows = cardBody.querySelectorAll('tr');
                    rows.forEach(function(row) {
                        var hhid = row.getAttribute('data-hhid').toLowerCase();
                        var fullName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                        if (hhid.includes(searchTerm) || fullName.includes(searchTerm)) {
                            row.style.display = ''; // Show row
                        } else {
                            row.style.display = 'none'; // Hide row
                        }
                    });
                });
            });

            // Global search functionality
            const globalSearchInput = document.getElementById('global-search');
            
            globalSearchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const barangayCards = document.querySelectorAll('.barangay-card');
                
                barangayCards.forEach(function(card) {
                    const barangayName = card.querySelector('.card-header h5').textContent.toLowerCase();
                    const pieChartCard = card.nextElementSibling; // Pie chart should be the next sibling
                    
                    if (barangayName.includes(searchTerm)) {
                        card.style.display = ''; // Show card
                        if (pieChartCard) {
                            pieChartCard.style.display = ''; // Show pie chart
                        }
                    } else {
                        card.style.display = 'none'; // Hide card
                        if (pieChartCard) {
                            pieChartCard.style.display = 'none'; // Hide pie chart
                        }
                    }
                });
            });
        });
    </script>
<?php endforeach; ?>


                            <?php
                                function formatHhid($hhid) {
                                    // Assuming $hhid is a string with 18 characters
                                    return substr($hhid, 0, 9) . '-' . substr($hhid, 9, 4) . '-' . substr($hhid, 13);
                                }
                                function formatid($id) {
                                    // Assuming $id is a string with 16 characters
                                    return substr($id, 0, 4) . '-' . substr($id, 4, 4) . '-' . substr($id, 8, 4) . '-' . substr($id, 12);
                                }
                            ?>
                          
           


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
    <!-- chart c3 js -->
    <script src="assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
   <!--  <script src="assets/vendor/charts/c3charts/C3chartjs.js"></script> -->

    <script>

        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = 'server/logout.php';
            }
        }

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