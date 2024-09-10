<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="icon" type="image/png" href="../assets/images/dswd-logo.png">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>
<!-- ============================================================== -->
<!-- signup form  -->
<!-- ============================================================== -->

<body>
    <!-- ============================================================== -->
    <!-- signup form  -->
    <!-- ============================================================== -->
    <form class="splash-container" method="post" action="server/register.php">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Registrations Form</h3>
                <p>Please enter your user information.</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" pattern="\d{9}-\d{4}-\d{5}" title="Please enter a valid HHID" name="hhid" required placeholder="HHID number" autocomplete="off">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="pass1" name="password" type="password" required placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="password" name="confirm_password" required placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="first_name" required placeholder="First Name">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="middle_name" placeholder="Middle Name">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="last_name" required placeholder="Last Name">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" pattern="[0-9]{11}" title="Please enter a valid 11-digit phone number" name="phone_number" required placeholder="Phone number">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="barangay" required placeholder="Barangay">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="purok" required placeholder="Purok">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="set" required placeholder="Set">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" pattern="\d{4}-\d{4}-\d{4}-\d{4}" name="phylsis_id" title="Please enter a valid national ID" required placeholder="Phylsis ID number" autocomplete="off">
                </div>
                <div class="form-group pt-2">
                    <button class="btn btn-block btn-primary" type="submit">Register My Account</button>
                </div>
            </div>
            <div class="card-footer bg-white">
                <p>Already member? <a href="login.php" class="text-secondary">Login Here.</a></p>
            </div>
        </div>
    </form>
</body>

 
</html>