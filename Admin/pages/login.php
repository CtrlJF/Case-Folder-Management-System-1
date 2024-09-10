<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
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
    .dswd {
        font-size: 32px;
        font-weight: bolder;
        color: rgb(89, 105, 255);
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><span class="dswd">DSWD 4P's</span><span class="splash-description">Please enter your user information.</span></div>
            <div class="card-body">
                <form method="post" action="server/sign-in.php">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="username" type="text" placeholder="ID number" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" type="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">Remember Me</span>
                        </label>
                    </div>
                   <!--  type="submit" -->
                    <button type="submit" class="btn btn-primary btn-lg btn-block" > Sign in</button>
                    <!-- <button type="button" class="btn btn-primary btn-lg btn-block" id="create-account-admin" >Create An Account </button> -->
                </form>
            </div>
            <div class="card-footer bg-white p-0 text-center">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="../../" class="footer-link">Back to Main Form</a>
                </div>
               <!--  <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Forgot Password</a>
                </div> -->
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>

    <!-- funtion of log in btn -->
    <script>

        const createAccountAdmin = document.getElementById('create-account-admin');

        createAccountAdmin.addEventListener('click', function() {
            window.location.href = 'sign-up.php';
        });

    </script>
</body>
 
</html>