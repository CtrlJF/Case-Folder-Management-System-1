<?php
session_start();

// Check if the user is not logged in, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: pages/login.php");
    exit;
}
if (isset($_GET['id']) && $_GET['type'] === 'view') {
    require_once 'server/displays/formview2_display.php';
} 
if (isset($_GET['id']) && $_GET['type'] === 'print') {
    require_once 'server/displays/formview2_display.php';
    echo "<script>
        window.onload = function() {
            window.print();
        };
        </script>    ";
}


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
    <title> View Beneficiary Profile </title>

    <style>
        td .form-control {
            border: none;
        }
        td .form-control:focus {
            outline: 0;
            box-shadow: none;
        }
        .table-wrapper {
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch; 
        }
        .underline {
            border: none;
            border-bottom: 1px solid #71748d; 
            background: transparent;
            resize: none;
            width: 100%; 
            font-size: 16px;
            padding: 5px 0; 
            outline: none;
        }
        body {
            background-color: #fff;
            padding: 50px 150px;
        }
        .underline:focus {
            box-shadow: none;      
        }
        @media (min-width: 992px) {
           .head-form {
                display: flex;
                justify-content: space-evenly;
           }
           .cont {
                display: flex;
           }
           .foot {
            display: flex;

            }  
        } 
        .row-cont {
            margin-bottom: 2px;
        }
        .cont .form-control{
            border: none;
            border-bottom: 1px solid  #71748d;
            padding-bottom: 0;
            padding-top: 0;
        }
        .cont .form-control:focus {
            outline: 0;
            box-shadow: none;
            border-color: #80bdff;
        }
        .foot {
            margin-top: 20px;
        }
        textarea {
            color: #333;
        }


        @media (max-width: 750px){

        }

    @media print {
        @page {
            size: landscape;
        }

        .no-print, head, footer {
            display: none;
        }
        body {
            margin: 0;
            padding: 0;
        }
        * {
            font-size: 12px; /* 11.5px */
            color: #333;
        }
        .content {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .head-form {
            display: flex;
            justify-content: space-between;
        }
        .logo-container {
            position: absolute;
            top: 0;
            left: 0;
            /* margin-right: 500px; */
        }
        .cont {
            display: flex;
        }
        .foot {
            display: flex;

        }
        .row-cont {
            margin-bottom: 2px;
        }
        .cont .form-control{
            border: none;
            border-bottom: 1px solid  #71748d;
            padding-bottom: 0;
            padding-top: 0;
        }
        .cont .form-control:focus {
            outline: 0;
            box-shadow: none;
            border-color: #80bdff;
        }
        td {
            padding: 1.5px !important; 
        }
        .container {
            padding-left: 100px;
            padding-right: 350px;
        }
        @page {
            margin: 0.32in; 
        }

}




    </style>
    
</head>

<body>
    <?php 
        if(isset($_SESSION['id_no'])) {
           echo'<button class="btn btn-primary no-print" onclick="window.print()">Print</button>'; 
        }
    ?>

<div class="content">
    <div class="">
        <div class="title">
            <div class="row justify-content-center">
                <div class="logo-container">
                    <img src="assets/images/dswd-logo.png" alt="DSWD Logo" class="img-fluid" style="max-height: 100px; width: 70px;">
                </div>
                <div class="col-md-8">
                    <div class="text-center">
                        <div>Department of Social Welfare and Development</div>
                        <div>Pantawid Pamilyang Pilipino Program</div>
                        <div class="mt-2"><strong>BENEFICIARY PROFILE</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="head-form mt-3">
            <div class="head-1">
                <div class="row-cont">
                    <div class="cont">
                        <label for="probinsya" class="form-label mr-3">Probinsya:</label>
                        <div class="">
                            <input type="text" class="form-control" id="probinsya" name="probinsya" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['probinsya'] ?? ''); ?>"> 
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="lungsod">Lungsod:</label>
                        <div class="">
                            <input type="text" class="form-control" id="lungsod" name="lungsod" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['lungsod'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="barangay">Barangay:</label>
                        <div class="">
                            <input type="text" class="form-control" id="barangay" name="barangay" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['barangay'] ?? ''); ?>"> 
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="purok">Purok/Street:</label>
                        <div class="">
                            <input type="text" class="form-control" id="purok" name="purok" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['purok'] ?? ''); ?>"> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="head-2">
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="hhid">Household ID:</label>
                        <div class="">
                            <input type="text" class="form-control" pattern="\d{9}-\d{4}-\d{5}" id="hhid" name="hhid" required value="<?php echo formathhid(htmlspecialchars($data['beneficiary_profile']['info']['household_id'] ?? '')); ?>"> 
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="memtribe">Membro sa Tribo:</label>
                        <div class="box-cont">
                            <label class="mr-3">
                                <?php $isMembro = $data['beneficiary_profile']['info']['membro_tribo'] === 'Oo'; ?>
                                Oo
                                <input type="checkbox" name="option1" value="Oo" <?php echo $isMembro ? 'checked' : ''; ?>>
                            </label>
                            <label>
                                Dli
                                <input type="checkbox" name="option1" value="Dli" <?php echo !$isMembro ? 'checked' : ''; ?>>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="nametribe">Pangalan sa Tribo:</label>
                        <div class="">
                            <input type="text" class="form-control" id="nametribe" name="nametribe" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['name_tribo'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="relihiyon">Relihiyon:</label>
                        <div class="">
                            <input type="text" class="form-control" id="relihiyon" name="relihiyon" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['relihiyon'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="numlivehouse"># of Families living in HH:</label>
                        <div class="">
                            <input type="number" class="form-control" id="numlivehouse" name="numlivehouse" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['family_size'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="head-3">
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="philhealth">Philhealth:</label>
                        <div class="box-cont">
                            <label class="mr-3">
                                <?php $hasPhilhealth = $data['beneficiary_profile']['info']['philhealth'] === 'Naa'; ?>
                                Naa
                                <input type="checkbox" name="option" value="Naa" <?php echo $hasPhilhealth ? 'checked' : ''; ?>>
                            </label>
                            <label>
                                Wala
                                <input type="checkbox" name="option" value="Wala" <?php echo !$hasPhilhealth ? 'checked' : ''; ?>>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row-cont pr-5">
                    <div class="cont">
                        <label class="mr-3" for="grant">Grant:</label>
                        <div class="box-cont">
                            <?php
                            $grantTypes = ['OTC', 'Cash Card', 'G-Remit'];
                            foreach ($grantTypes as $grantType):
                                $isChecked = strpos($data['beneficiary_profile']['info']['usergrant'] ?? '', $grantType) !== false;
                            ?>
                                <label class="mr-2">
                                    <?php echo $grantType; ?>
                                    <input type="checkbox" name="option2[]" value="<?php echo $grantType; ?>" <?php echo $isChecked ? 'checked' : ''; ?>>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="accnum">Account #:</label>
                        <div class="">
                            <input type="text" class="form-control" id="accnum" name="accnum" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['account_num'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="hhstat">HH Status:</label>
                        <div class="">
                            <input type="text" class="form-control" id="hhstat" name="hhstat" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['hh_status'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="row-cont">
                    <div class="cont">
                        <label class="mr-3" for="dailyincome">Daily Income:</label>
                        <div class="">
                            <input type="number" class="form-control" id="dailyincome" name="dailyincome" step="0.01" min="0" required value="<?php echo htmlspecialchars($data['beneficiary_profile']['info']['daily_income'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="body mt-3">
            <div class="">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="text-center">
                            <div><strong>MEMBRO SA HOUSEHOLD</strong></div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px;">No.</th>
                            <th style="width: 120px;">Apilyedo</th>
                            <th style="width: 120px;">Pangalan</th>
                            <th style="width: 120px;">Inisyal sa Tunga</th>
                            <th style="width: 90px;">Petsa sa Pagkatawo</th>
                            <th style="width: 60px;">Seks</th>
                            <th style="width: 80px;">Pagka Pamilya</th>
                            <th style="width: 60px;">Sibil</th>
                            <th style="width: 50px;">Buntis (Oo or Dli)</th>
                            <th style="width: 50px;">Nag eskwela (Oo or Dli)</th>
                            <th style="width: 80px;">Grado</th>
                            <th style="width: 70px;">Na Rehistro nga Grantee (Oo or Dli)</th>
                            <th style="width: 100px;">Panginabuhi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($data['beneficiary_profile']['info']['hh_member']) && is_array($data['beneficiary_profile']['info']['hh_member'])): ?>
                            <?php foreach ($data['beneficiary_profile']['info']['hh_member'] as $i => $member): ?>
                                <tr>
                                    <td class="text-center"><?php echo $i + 1; ?></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="lname_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['lname'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="fname_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['fname'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="mname_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['mname'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="birthday_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['birthday'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="gender_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['gender'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="family_relation_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['family_relation'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="civil_status_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['civil_status'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="buntis_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['buntis'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="school_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['school'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="grade_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['grade'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="register_grantee_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['register_grant'] ?? ''); ?>"></td>
                                    <td><input type="text" class="form-control p-0 m-0" name="work_living_<?php echo $i + 1; ?>" value="<?php echo htmlspecialchars($member['livelihood'] ?? ''); ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="13" class="text-center">No members data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="foot">
            <div class="">
                <table class="table table-bordered" style="width: 550px;">
                    <div><strong>NADAWAT NGA CASH GRANT</strong></div>   
                    <thead>
                        <tr>
                            <th>TUIG.</th>
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
                        // Check if 'cash_received' data exists
                        $cashReceivedData = $data['beneficiary_profile']['info']['cash_received'] ?? [];

                        // If 'cash_received' data exists and is an array, iterate over it
                        if (is_array($cashReceivedData) && !empty($cashReceivedData)):
                        ?>
                            <?php foreach ($cashReceivedData as $grant): ?>
                                <tr>
                                    <td class="text-center"><?php echo htmlspecialchars($grant['year']); ?></td>
                                    <td><input type="number" class="form-control p-0 m-0" name="dec-jan_<?php echo htmlspecialchars($grant['year']); ?>" value="<?php echo htmlspecialchars($grant['dec_jan'] ?? ''); ?>"></td>
                                    <td><input type="number" class="form-control p-0 m-0" name="feb-mar_<?php echo htmlspecialchars($grant['year']); ?>" value="<?php echo htmlspecialchars($grant['feb_mar'] ?? ''); ?>"></td>
                                    <td><input type="number" class="form-control p-0 m-0" name="apr-may_<?php echo htmlspecialchars($grant['year']); ?>" value="<?php echo htmlspecialchars($grant['apr_may'] ?? ''); ?>"></td>
                                    <td><input type="number" class="form-control p-0 m-0" name="june-jul_<?php echo htmlspecialchars($grant['year']); ?>" value="<?php echo htmlspecialchars($grant['june_jul'] ?? ''); ?>"></td>
                                    <td><input type="number" class="form-control p-0 m-0" name="aug-sept_<?php echo htmlspecialchars($grant['year']); ?>" value="<?php echo htmlspecialchars($grant['aug_sept'] ?? ''); ?>"></td>
                                    <td><input type="number" class="form-control p-0 m-0" name="oct-nov_<?php echo htmlspecialchars($grant['year']); ?>" value="<?php echo htmlspecialchars($grant['oct_nov'] ?? ''); ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No cash received data available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>  
            <div class="container">
                <div><strong>GI-UNSA PAG GAMIT ANG KWARTA:</strong></div>
                <?php
                // Retrieve the value and ensure it is at most 58 characters
                $cashUseValue = htmlspecialchars($data['beneficiary_profile']['info']['use_money'] ?? '');
                $cashUseValue = substr($cashUseValue, 0, 58); // Ensure it does not exceed 58 characters
                $cashUseValue1 = htmlspecialchars($data['beneficiary_profile']['info']['use_money'] ?? '');
                $cashUseValue1 = substr($cashUseValue1, 58, 116);
                $cashUseValue2 = htmlspecialchars($data['beneficiary_profile']['info']['use_money'] ?? '');
                $cashUseValue2 = substr($cashUseValue2, 116, 174);
                $cashUseValue3 = htmlspecialchars($data['beneficiary_profile']['info']['use_money'] ?? '');
                $cashUseValue3 = substr($cashUseValue2, 174, 232);
                ?>
                <textarea class="underline p-0 m-0" name="cash-use-1" maxlength="58" rows="1" required><?php echo htmlspecialchars($cashUseValue); ?></textarea>
                <textarea class="underline p-0 m-0" name="cash-use-1" maxlength="58" rows="1" required><?php echo htmlspecialchars($cashUseValue1); ?></textarea>
                <textarea class="underline p-0 m-0" name="cash-use-1" maxlength="58" rows="1" required><?php echo htmlspecialchars($cashUseValue2); ?></textarea>
                <textarea class="underline p-0 m-0" name="cash-use-1" maxlength="58" rows="1" required><?php echo htmlspecialchars($cashUseValue3); ?></textarea>
            </div>          
        </div>                        
    </div>
</div>



    <!-- jquery 3.3.1 -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>

</body>
 
</html>