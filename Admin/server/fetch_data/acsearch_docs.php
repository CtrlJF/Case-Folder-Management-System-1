<?php
session_start();

if(isset($_SESSION['id_no'])) {
    require_once(__DIR__ . '/../../../libraries/database.php');

    $table = $_POST['data_table'];
    $acc_id = $_POST['data_user_id'];
    /* $table = 'National_ID'; */

    function executeQuery(PDO $pdo, string $query): array {
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $directories = [
        'National_ID' => '../uploads/nationalID/',
        'Family_Photo' => '../uploads/fampick/',
        'Pantawid_ID' => '../uploads/pantawidID/',
        'Cash_Card' => '../uploads/cashcard/',
        'Kasabutan' => '../uploads/kasabutan/',
        'Birth_Certificate' => '../uploads/birthcert/',
        'Marriage_Contract' => '../uploads/marriagecont/',
        'Immunization_Record' => '../uploads/immurec/',
        'Grade_Cards' => '../uploads/gradecards/',
        'MDR' => '../uploads/mdr/',
        'Certificate' => '../uploads/certattend/',
        'Beneficiary_Profile' => '../user/formview2.php?id='
    ];


    function generateBeneficiaryProfile(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
        foreach ($rows as $user) {
            $bpId = $user['beneficiary_profile_id'];
            $imgName = 'Beneficiary Profile';
            $imgUpload = $user['beneficiary_profile_upload'];
            $Path = ($table === 'Beneficiary_Profile') ? $directories[$table] . $bpId . '&type=view' : '#';
            /* $imagePath = $directories[$table] . $id . '&type=view' : '#'; */

            $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';

            $html .= '<a href="' . htmlspecialchars($Path) . '" target="_blank">';
            $html .= '<img src="assets/images/bp.png" class="card-img-top img-fluid" alt="' . htmlspecialchars($table) . '"> </a>';

            $html .= '</a>';
            $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
            $html .= '</p>';
            $html .= '</div></div></div>';  
        }
        $html .= '</div></div>';  
        return $html;
    }


    function generateBirthCertificate(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            // Split the IDs and images into arrays
            $imageIds = explode(',', $user['birth_ids']);
            $imageFiles = explode(',', $user['birth_imgs']);
            $imageName = explode(',', $user['birth_names']);
            $imageUpload = explode(',', $user['birth_uploads']);
            $imagefamrole = explode(',', $user['birth_famroles']);
    
            // Loop through the images and generate HTML for each
            foreach ($imageIds as $index => $id) {
                $imgFile = $imageFiles[$index];
                $imgName = $imageName[$index];
                $imgUpload = $imageUpload[$index];
                $imgfamrole = $imagefamrole[$index];
                $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
                
                // Assuming all images are PDFs here. Adjust logic if you have different file types
                $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
  
                $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
                $html .= '<div class="card">';
                $html .= '<div class="card-body">';
                
                if ($isPdf) {
                    $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                    $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
                } else {
                    $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                    $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
                }
                
                $html .= '</a>';
                $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
                $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
                $html .= '<span><strong>Family Role:</strong> ' . htmlspecialchars($imgfamrole) . '</span></p>';
                $html .= '</div></div></div>';
            }
        }
        $html .= '</div></div>';
        return $html;
    }

    
    function generateNationalID(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            // Split the IDs and images into arrays
            $imageIds = explode(',', $user['national_id_ids']);
            $imageFiles = explode(',', $user['national_id_imgs']);
            $imageName = explode(',', $user['national_id_names']);
            $imageUpload = explode(',', $user['national_id_uploads']);
            $imagefamrole = explode(',', $user['national_id_famroles']);
    
            // Loop through the images and generate HTML for each
            foreach ($imageIds as $index => $id) {
                $imgFile = $imageFiles[$index];
                $imgName = $imageName[$index];
                $imgUpload = $imageUpload[$index];
                $imgfamrole = $imagefamrole[$index];
                $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
                
                // Assuming all images are PDFs here. Adjust logic if you have different file types
                $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
                
                $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
                $html .= '<div class="card">';
                $html .= '<div class="card-body">';

                if ($isPdf) {
                    $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                    $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
                } else {
                    $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                    $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
                }
                
                $html .= '</a>';
                $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
                $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
                $html .= '<span><strong>Family Role:</strong> ' . htmlspecialchars($imgfamrole) . '</span></p>';
                $html .= '</div></div></div>';
            }
        }
        $html .= '</div></div>';
        return $html;
    }
    

    function generateGradeCards(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            // Split the IDs and images into arrays
            $imageIds = explode(',', $user['grade_card_ids']);
            $imageFiles = explode(',', $user['grade_card_imgs']);
            $imageName = explode(',', $user['grade_card_names']);
            $imageUpload = explode(',', $user['grade_card_uploads']);
    
            // Loop through the images and generate HTML for each
            foreach ($imageIds as $index => $id) {
                $imgFile = $imageFiles[$index];
                $imgName = $imageName[$index];
                $imgUpload = $imageUpload[$index];
                $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
                
                // Assuming all images are PDFs here. Adjust logic if you have different file types
                $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
                
                $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
                $html .= '<div class="card">';
                $html .= '<div class="card-body">';
                
                if ($isPdf) {
                    $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                    $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
                } else {
                    $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                    $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
                }
                
                $html .= '</a>';
                $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
                $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
                $html .= '</p>';
                $html .= '</div></div></div>';
            }
        }
        $html .= '</div></div>';
        return $html;
    }


    function generateFamilyPhoto(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            $imgFile = $user['family_photo_img'];
            $imgName = $user['family_photo_name'];
            $imgUpload = $user['family_photo_upload'];
            $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
            
            // Assuming all images are PDFs here. Adjust logic if you have different file types
            $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
             
            $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';
                
            if ($isPdf) {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
            } else {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
            }
                
            $html .= '</a>';
            $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
            $html .= '</p>';
            $html .= '</div></div></div>';   
        }
        $html .= '</div></div>'; 
        return $html;
    }


    function generatePantawidID(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            $imgFile = $user['pantawid_img'];
            $imgName = $user['pantawid_name'];
            $imgUpload = $user['pantawid_upload'];
            $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
            
            // Assuming all images are PDFs here. Adjust logic if you have different file types
            $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
   
            $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';
                
            if ($isPdf) {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
            } else {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
            }
                
            $html .= '</a>';
            $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
            $html .= '</p>';
            $html .= '</div></div></div>';   
        }
        $html .= '</div></div>';  
        return $html;
    }


    function generateCashCard(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            $imgFile = $user['cash_card_img'];
            $imgName = $user['cash_card_name'];
            $imgUpload = $user['cash_card_upload'];
            $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
            
            // Assuming all images are PDFs here. Adjust logic if you have different file types
            $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';

            $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';
                
            if ($isPdf) {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
            } else {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
            }
            
            $html .= '</a>';
            $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
            $html .= '</p>';
            $html .= '</div></div></div>';   
        }
        $html .= '</div></div>';  
        return $html;
    }


    function generateKasabutan(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            $imgFile = $user['kasabutan_img'];
            $imgName = $user['kasabutan_name'];
            $imgUpload = $user['kasabutan_upload'];
            $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
            
            // Assuming all images are PDFs here. Adjust logic if you have different file types
            $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
            
            $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';
                
            if ($isPdf) {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
            } else {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
            }
                
            $html .= '</a>';
            $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
            $html .= '</p>';
            $html .= '</div></div></div>'; 
        }
        $html .= '</div></div>'; 
        return $html;
    }


    function generateMarriageContract(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            $imgFile = $user['marriage_contract_img'];
            $imgName = $user['marriage_contract_name'];
            $imgUpload = $user['marriage_contract_upload'];
            $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
            
            // Assuming all images are PDFs here. Adjust logic if you have different file types
            $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
              
            $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';
                
            if ($isPdf) {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
            } else {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
            }
                
            $html .= '</a>';
            $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
            $html .= '</p>';
            $html .= '</div></div></div>';   
        }
        $html .= '</div></div>';  
        return $html;
    }


    function generateImmunization(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            $imgFile = $user['immunization_record_img'];
            $imgName = $user['immunization_record_name'];
            $imgUpload = $user['immunization_record_upload'];
            $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
            
            // Assuming all images are PDFs here. Adjust logic if you have different file types
            $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
            
            $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';
                
            if ($isPdf) {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
            } else {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
            }
                
            $html .= '</a>';
            $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
            $html .= '</p>';
            $html .= '</div></div></div>';  
        }
        $html .= '</div></div>';  
        return $html;
    }


    function generateMDR(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';
    
        foreach ($rows as $user) {
            $imgFile = $user['mdr_img'];
            $imgName = $user['mdr_name'];
            $imgUpload = $user['mdr_upload'];
            $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
            
            // Assuming all images are PDFs here. Adjust logic if you have different file types
            $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
 
            $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';
            
            if ($isPdf) {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
            } else {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
            }
            
            $html .= '</a>';
            $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
            $html .= '</p>';
            $html .= '</div></div></div>';   
        }
        $html .= '</div></div>';   
        return $html;
    }


    function generateCertificate(array $rows, string $table, array $directories): string {
        $html = '';
        $html .= '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
        $html .= '<div class="row">';

        foreach ($rows as $user) {
            $imgFile = $user['certificate_img'];
            $imgName = $user['certificate_name'];
            $imgUpload = $user['certificate_upload'];
            $imagePath = (isset($directories[$table]) ? $directories[$table] . htmlspecialchars($imgFile) : '#');
            
            // Assuming all images are PDFs here. Adjust logic if you have different file types
            $isPdf = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)) === 'pdf';
            
            $html .= '<div class="col-lg-2 col-md-4 col-sm-6">';
            $html .= '<div class="card">';
            $html .= '<div class="card-body">';
                
            if ($isPdf) {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="assets/images/pdf.png" class="card-img-top img-fluid" alt="PDF Document">';
            } else {
                $html .= '<a href="' . htmlspecialchars($imagePath) . '" target="_blank">';
                $html .= '<img src="' . htmlspecialchars($imagePath) . '" class="card-img-top img-fluid" alt="Image Document">';
            }
                
            $html .= '</a>';
            $html .= '<p class="mt-1"><span><strong>Name:</strong> ' . htmlspecialchars($imgName) . '</span><br>';
            $html .= '<span><strong>Year:</strong> ' . htmlspecialchars($imgUpload) . '</span><br>';
            $html .= '</p>';
            $html .= '</div></div></div>';   
        }
        $html .= '</div></div>';  
        return $html;
    }


    switch ($table) {
        case 'Birth_Certificate':
            $query = "
                SELECT
                    ua.acc_id,
                    GROUP_CONCAT(CASE WHEN ubc.status = 'approved' THEN ubc.id END) AS birth_ids,
                    GROUP_CONCAT(CASE WHEN ubc.status = 'approved' THEN ubc.img END) AS birth_imgs,
                    GROUP_CONCAT(CASE WHEN ubc.status = 'approved' THEN ubc.name END) AS birth_names,
                    GROUP_CONCAT(CASE WHEN ubc.status = 'approved' THEN ubc.famrole END) AS birth_famroles,
                    GROUP_CONCAT(CASE WHEN ubc.status = 'approved' THEN ubc.upload END) AS birth_uploads
                FROM
                    user_account ua
                LEFT JOIN
                    user_birth_certificate ubc ON ua.acc_id = ubc.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateBirthCertificate($rows, $table, $directories);
            echo $html;
            break;

        case 'National_ID':
            $query = "
                SELECT
                    ua.acc_id,
                    GROUP_CONCAT(CASE WHEN uni.status = 'approved' THEN uni.id END) AS national_id_ids,
                    GROUP_CONCAT(CASE WHEN uni.status = 'approved' THEN uni.img END) AS national_id_imgs,
                    GROUP_CONCAT(CASE WHEN uni.status = 'approved' THEN uni.name END) AS national_id_names,
                    GROUP_CONCAT(CASE WHEN uni.status = 'approved' THEN uni.famrole END) AS national_id_famroles,
                    GROUP_CONCAT(CASE WHEN uni.status = 'approved' THEN uni.upload END) AS national_id_uploads
                FROM
                    user_account ua
                LEFT JOIN
                    user_national_id uni ON ua.acc_id = uni.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateNationalID($rows, $table, $directories);
            echo $html;
            break;
    
        case 'Family_Photo':
            $query = "
                SELECT
                    ua.acc_id,
                    MAX(CASE WHEN fp.status = 'approved' AND YEAR(fp.upload) = YEAR(CURDATE()) THEN fp.id END) AS family_photo_id,
                    MAX(CASE WHEN fp.status = 'approved' AND YEAR(fp.upload) = YEAR(CURDATE()) THEN fp.name END) AS family_photo_name,
                    MAX(CASE WHEN fp.status = 'approved' AND YEAR(fp.upload) = YEAR(CURDATE()) THEN fp.img END) AS family_photo_img,
                    MAX(CASE WHEN fp.status = 'approved' AND YEAR(fp.upload) = YEAR(CURDATE()) THEN fp.upload END) AS family_photo_upload
                FROM
                    user_account ua
                LEFT JOIN
                    user_family_photo fp ON ua.acc_id = fp.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateFamilyPhoto($rows, $table, $directories);
            echo $html;
            break;
    
        case 'Pantawid_ID':
            $query = "
                SELECT
                    ua.acc_id,
                    MAX(CASE WHEN upi.status = 'approved' THEN upi.id END) AS pantawid_id,
                    MAX(CASE WHEN upi.status = 'approved' THEN upi.img END) AS pantawid_img,
                    MAX(CASE WHEN upi.status = 'approved' THEN upi.name END) AS pantawid_name,
                    MAX(CASE WHEN upi.status = 'approved' THEN upi.upload END) AS pantawid_upload
                FROM
                    user_account ua
                LEFT JOIN
                    user_pantawid_id upi ON ua.acc_id = upi.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generatePantawidID($rows, $table, $directories);
            echo $html;
            break;
    
        case 'Cash_Card':
            $query = "
                SELECT
                    ua.acc_id,
                    MAX(CASE WHEN ucc.status = 'approved' THEN ucc.id END) AS cash_card_id,
                    MAX(CASE WHEN ucc.status = 'approved' THEN ucc.name END) AS cash_card_name,
                    MAX(CASE WHEN ucc.status = 'approved' THEN ucc.img END) AS cash_card_img,
                    MAX(CASE WHEN ucc.status = 'approved' THEN ucc.upload END) AS cash_card_upload
                FROM
                    user_account ua
                LEFT JOIN
                    user_cash_card ucc ON ua.acc_id = ucc.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateCashCard($rows, $table, $directories);
            echo $html;
            break;
    
        case 'Kasabutan':
            $query = "
                SELECT
                    ua.acc_id,
                    MAX(CASE WHEN uk.status = 'approved' THEN uk.id END) AS kasabutan_id,
                    MAX(CASE WHEN uk.status = 'approved' THEN uk.name END) AS kasabutan_name,
                    MAX(CASE WHEN uk.status = 'approved' THEN uk.img END) AS kasabutan_img,
                    MAX(CASE WHEN uk.status = 'approved' THEN uk.upload END) AS kasabutan_upload
                FROM
                    user_account ua
                LEFT JOIN
                    user_kasabutan uk ON ua.acc_id = uk.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateKasabutan($rows, $table, $directories);
            echo $html;
            break;
    
        case 'Marriage_Contract':
            $query = "
                SELECT
                    ua.acc_id,
                    MAX(CASE WHEN umc.status = 'approved' THEN umc.id END) AS marriage_contract_id,
                    MAX(CASE WHEN umc.status = 'approved' THEN umc.name END) AS marriage_contract_name,
                    MAX(CASE WHEN umc.status = 'approved' THEN umc.img END) AS marriage_contract_img,
                    MAX(CASE WHEN umc.status = 'approved' THEN umc.upload END) AS marriage_contract_upload
                FROM
                    user_account ua
                LEFT JOIN
                    user_marriage_contract umc ON ua.acc_id = umc.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateMarriageContract($rows, $table, $directories);
            echo $html;
            break;
    
        case 'Immunization_Record':
            $query = "
                SELECT
                    ua.acc_id,
                    MAX(CASE WHEN uir.status = 'approved' THEN uir.id END) AS immunization_record_id,
                    MAX(CASE WHEN uir.status = 'approved' THEN uir.name END) AS immunization_record_name,
                    MAX(CASE WHEN uir.status = 'approved' THEN uir.img END) AS immunization_record_img,
                    MAX(CASE WHEN uir.status = 'approved' THEN uir.upload END) AS immunization_record_upload
                FROM
                    user_account ua
                LEFT JOIN
                    user_immunization_record uir ON ua.acc_id = uir.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateImmunization($rows, $table, $directories);
            echo $html;
            break;
    
        case 'Grade_Cards':
            $query = "
                SELECT
                    ugc.acc_id,
                    GROUP_CONCAT(ugc.id) AS grade_card_ids,
                    GROUP_CONCAT(ugc.name) AS grade_card_names,
                    GROUP_CONCAT(ugc.img) AS grade_card_imgs,
                    GROUP_CONCAT(ugc.upload) AS grade_card_uploads
                FROM
                    user_grade_cards ugc
                WHERE
                    ugc.status = 'approved' 
                    AND ugc.acc_id = $acc_id
                    AND YEAR(ugc.upload) = YEAR(CURDATE())  -- Filter for current year
                GROUP BY
                    ugc.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateGradeCards($rows, $table, $directories);
            echo $html;
            break;
    
        case 'MDR':
            $query = "
                SELECT
                    ua.acc_id,
                    MAX(CASE WHEN um.status = 'approved' THEN um.id END) AS mdr_id,
                    MAX(CASE WHEN um.status = 'approved' THEN um.name END) AS mdr_name,
                    MAX(CASE WHEN um.status = 'approved' THEN um.img END) AS mdr_img,
                    MAX(CASE WHEN um.status = 'approved' THEN um.upload END) AS mdr_upload
                FROM
                    user_account ua
                LEFT JOIN
                    user_mdr um ON ua.acc_id = um.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateMDR($rows, $table, $directories);
            echo $html;
            break;
    
        case 'Certificate':
            $query = "
                SELECT
                    ua.acc_id,
                    MAX(CASE WHEN uc.status = 'approved' THEN uc.id END) AS certificate_id,
                    MAX(CASE WHEN uc.status = 'approved' THEN uc.name END) AS certificate_name,
                    MAX(CASE WHEN uc.status = 'approved' THEN uc.img END) AS certificate_img,
                    MAX(CASE WHEN uc.status = 'approved' THEN uc.upload END) AS certificate_upload
                FROM
                    user_account ua
                LEFT JOIN
                    user_certificate uc ON ua.acc_id = uc.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateCertificate($rows, $table, $directories);
            echo $html;
            break;
    
        case 'Beneficiary_Profile':
            $query = "
                SELECT
                    ua.acc_id,
                    MAX(CASE WHEN bp.status = 'approved' AND YEAR(bp.upload) = YEAR(CURDATE()) THEN bp.id END) AS beneficiary_profile_id,
                    MAX(CASE WHEN bp.status = 'approved' AND YEAR(bp.upload) = YEAR(CURDATE()) THEN bp.upload END) AS beneficiary_profile_upload
                FROM
                    user_account ua
                LEFT JOIN
                    user_beneficiary_profile bp ON ua.acc_id = bp.acc_id
                WHERE
                    ua.status = 'active' AND ua.acc_id = $acc_id
                GROUP BY
                    ua.acc_id;
            ";
            $rows = executeQuery($pdo, $query);
            $html = generateBeneficiaryProfile($rows, $table, $directories);
            echo $html;
            break;
    
        default:
            echo 'Unknown document type!';
            exit;
    }
    
   /*  echo "<pre>";
    print_r($rows);
    echo "</pre>"; */
    
} else {
    header('HTTP/1.1 403 Forbidden');
    echo 'Account ID not found in session.';
}
/* $imgUrl = ($directories[$doc['table_name']] === 'Beneficiary Profile') ? $directories[$doc['table_name']] . $id . '&type=view': (isset($directories[$type]) ? $directories[$type] . $img : '#'); */
unset($pdo);

?>