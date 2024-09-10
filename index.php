<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSWD 4P's Case Folder Management System</title>
    <link rel="stylesheet" href="User/assets/libs/css/style.css">
    <link rel="icon" type="image/png" href="admin/assets/images/dswd-logo.png">

     <style>
        main {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 67vh;
        }
        .container {
            /* border: 2px solid #333; */
            padding: 20px;
            text-align: center;
        }
        .title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        footer {
            display: flex;
            justify-content: center;
        }  
        .text-center {
            text-align: center;
        }
        @media (max-width: 480px) {
            .container {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .button {
                margin-bottom: 10px;
            }
        }
     </style>

</head>
<body>
    <header>
        <div>
            <img src="dswdLogo.jpg" alt="Dswd Logo" style="width: 100%; height:200px;">
        </div>
    </header>
    <main>
        <div class="container">
            <span class="title">Case Folder :</span>
            <button class="button" onclick="window.location.href='User/pages/login.php'" >Beneficiary</button>
            <button class="button" onclick="window.location.href='Admin/pages/login.php'" >Admin</button> 
        </div>
    </main>
    <footer>
        <div >
            <div >
                <div class="text-center">Develop by: Julios Felisilda, Lemuel Golis, John Michael Nakila</div>
                <div >
                     Copyright © 2024 Department of Social Welfare Development 4P's Case Folder Management System. All rights reserved.
                </div>
                
                <!-- <div >
                     Develop By:
                     <span>Julios Felisilda,</span>
                     <span>Lemuel Golis,</span>
                     <span>John Michael Nakila</span>
                </div> -->
            </?div>
        </div>
    </footer>
</body>
</html>