<?php
session_start();
/* require('vendor/setasign/fpdf/fpdf.php'); */
require 'table_structure.php'; 

class PDF extends PDF_MC_Table {

    public $barangay;
    public $AdminName;

    function Header() {
        // Add the image
        $this->Image('assets/images/dswd-logo.png', 10, 10, 30); // Adjust the x, y, and size parameters as needed
        $this->Image('assets/images/buenaLogo.png', 255, 10, 25);
        // Set font for the main title
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 7, 'Department of Social Welfare and Development', 0, 1, 'C');
        // Set font for the location
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 7, 'Buenavista, Agusan Del Norte. 8601 Philippines', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 7, 'Active Beneficiary Reports', 0, 1, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $this->barangay, 0, 1, 'C');
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 10);

        // Define the column widths and alignments
        $this->SetWidths([36, 41, 17, 15, 19, 11, 21, 20, 18, 15, 15, 11, 20, 22]);
        $this->SetAligns(['L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L']);

        // Print header row
        $this->Row([
            'Name',
            'HHID',
            'National ID',
            'Family Photo',
            'Pantawid ID',
            'Cash Card',
            'Kasabutan',
            'Birth Certificate',
            'Marriage Contract',
            'Immunization Record',
            'Grade Card',
            'MDR',
            'Certificate',
            'Beneficiary Profile',
        ]);
    }

    function Footer() {
        // Set the position to 15 mm from the bottom
       $this->SetY(-15);
       // Set font for the footer text
       $this->SetFont('Arial', 'I', 8);
       // Get the page width
       $pageWidth = $this->GetPageWidth();
       // Date on the left
       $date = date('F j, Y'); // Example date format
       $this->SetX(10); // Position from the left margin
       $this->Cell(0, 10, 'Date: ' . $date, 0, 0, 'L');
       // Page number in the center
       $this->SetX($pageWidth / 28); // Move to the center
       $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
       // Generated by on the right
       $this->SetX($pageWidth - 60); // Move to the right (adjust the 60 as needed for spacing)
       $this->Cell(0, 10, 'Generated by: ' . $this->AdminName, 0, 0, 'R');
    }

    function ChapterBody($data) {
        $this->SetFont('Arial', '', 10);

        foreach ($data as $row) {
            /* $this->Cell(36, 10, htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']), 1);
            $this->Cell(41, 10, formathhid(htmlspecialchars($row['hhid'])), 1);

            $this->Cell(17, 10, $row['national_id_ids'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(15, 10, $row['family_photo_id'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(19, 10, $row['pantawid_id'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(11, 10, $row['cash_card_id'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(21, 10, $row['kasabutan_id'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(20, 10, $row['birth_certificate_ids'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(18, 10, $row['marriage_contract_id'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(15, 10, $row['immunization_record_id'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(15, 10, $row['grade_card_ids'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(11, 10, $row['mdr_id'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(20, 10, $row['certificate_id'] ? 'Yes' : 'No', 1, 0, 'C');
            $this->Cell(22, 10, $row['beneficiary_profile_id'] ? 'Yes' : 'No', 1, 0, 'C');

            $this->Ln(); */
            $this->SetAligns(['L', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C']);

            $rowData = [
                htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']),
                formathhid(htmlspecialchars($row['hhid'])),
                $row['national_id_ids'] ? 'Yes' : 'No',
                $row['family_photo_id'] ? 'Yes' : 'No',
                $row['pantawid_id'] ? 'Yes' : 'No',
                $row['cash_card_id'] ? 'Yes' : 'No',
                $row['kasabutan_id'] ? 'Yes' : 'No',
                $row['birth_certificate_ids'] ? 'Yes' : 'No',
                $row['marriage_contract_id'] ? 'Yes' : 'No',
                $row['immunization_record_id'] ? 'Yes' : 'No',
                $row['grade_card_ids'] ? 'Yes' : 'No',
                $row['mdr_id'] ? 'Yes' : 'No',
                $row['certificate_id'] ? 'Yes' : 'No',
                $row['beneficiary_profile_id'] ? 'Yes' : 'No'
            ];
    
            // Add a row with multi-line text handling
            $this->Row($rowData);
        }
    }

}


class PDFALL extends PDF_MC_Table {

    public $barangay;
    public $AdminName;

    function Header() {
        // Add the image
        $this->Image('assets/images/dswd-logo.png', 10, 10, 30); // Adjust the x, y, and size parameters as needed
        $this->Image('assets/images/buenaLogo.png', 255, 10, 25);
        // Set font for the main title
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 7, 'Department of Social Welfare and Development', 0, 1, 'C');
        // Set font for the location
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 7, 'Buenavista, Agusan Del Norte. 8601 Philippines', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 7, 'Active Beneficiary Reports', 0, 1, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, $this->barangay, 0, 1, 'C');
        $this->Ln(10);

        $this->SetFont('Arial', 'B', 10);

        // Define the column widths and alignments
        $this->SetWidths([36, 41, 17, 15, 19, 11, 21, 20, 18, 15, 15, 11, 20, 22]);
        $this->SetAligns(['L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L']);

        // Print header row
        $this->Row([
            'Name',
            'HHID',
            'National ID',
            'Family Photo',
            'Pantawid ID',
            'Cash Card',
            'Kasabutan',
            'Birth Certificate',
            'Marriage Contract',
            'Immunization Record',
            'Grade Card',
            'MDR',
            'Certificate',
            'Beneficiary Profile',
        ]);
    }

    function Footer() {
         // Set the position to 15 mm from the bottom
       $this->SetY(-15);
       // Set font for the footer text
       $this->SetFont('Arial', 'I', 8);
       // Get the page width
       $pageWidth = $this->GetPageWidth();
       // Date on the left
       $date = date('F j, Y'); // Example date format
       $this->SetX(10); // Position from the left margin
       $this->Cell(0, 10, 'Date: ' . $date, 0, 0, 'L');
       // Page number in the center
       $this->SetX($pageWidth / 28); // Move to the center
       $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
       // Generated by on the right
       $this->SetX($pageWidth - 60); // Move to the right (adjust the 60 as needed for spacing)
       $this->Cell(0, 10, 'Generated by: ' . $this->AdminName, 0, 0, 'R');
    }

    function ChapterBody($data) {
        $this->SetFont('Arial', '', 10);

        $this->SetAligns(['L', 'L', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C']);
        
        foreach ($data as $name => $details) {
            preg_match('/^(.*)\s\((\d+)\)$/', $name, $matches);
            $name = $matches[1] ?? 'N/A'; 
            $hhid = $matches[2] ?? 'N/A'; 

            // Prepare data for each row
            $row = [];
            $row[] = htmlspecialchars($name);
            $row[] = formathhid(htmlspecialchars($hhid));

            // Prepare National ID documents
            $nidDetails = '';
            if (!empty($details['user_national_id'])) {
                foreach ($details['user_national_id'] as $nid) {
                    /* $nidDetails .= $nid['upload'] . " "; */
                    $nidDetails .= date('Y', strtotime($nid['upload'])) . "\n";
                }
            }
            $row[] = trim($nidDetails);

            // Prepare Family Photo Result documents
            $phDetails = '';
            if (!empty($details['user_family_photo'])) {
                foreach ($details['user_family_photo'] as $ph) {
                    $phDetails .= date('Y', strtotime($ph['upload'])) . "\n";
                }
            }
            $row[] = trim($phDetails);

            // Prepare Pantawid ID documents
            $pidDetails = '';
            if (!empty($details['user_pantawid_id'])) {
                foreach ($details['user_pantawid_id'] as $pid) {
                    $pidDetails .= date('Y', strtotime($pid['upload'])) . "\n";
                }
            }
            $row[] = trim($pidDetails);

            // Prepare cash card documents
            $ccDetails = '';
            if (!empty($details['user_cash_card'])) {
                foreach ($details['user_cash_card'] as $cc) {
                    $ccDetails .= date('Y', strtotime($cc['upload'])) . "\n";
                }
            }
            $row[] = trim($ccDetails);

            // Prepare kasabutan documents
            $kDetails = '';
            if (!empty($details['user_kasabutan'])) {
                foreach ($details['user_kasabutan'] as $k) {
                    $kDetails .= date('Y', strtotime($k['upload'])) . "\n";
                }
            }
            $row[] = trim($kDetails);

            // Prepare Birth Certificate documents
            $bcDetails = '';
            if (!empty($details['user_birth_certificate'])) {
                foreach ($details['user_birth_certificate'] as $bc) {
                    $bcDetails .= date('Y', strtotime($bc['upload'])) . "\n";
                }
            }
            $row[] = trim($bcDetails);

            // Prepare Marriage Contract documents
            $mcDetails = '';
            if (!empty($details['user_marriage_contract'])) {
                foreach ($details['user_marriage_contract'] as $mc) {
                    $mcDetails .= date('Y', strtotime($mc['upload'])) . "\n";
                }
            }
            $row[] = trim($mcDetails);

            // Prepare Immunization Record documents
            $irDetails = '';
            if (!empty($details['user_immunization_record'])) {
                foreach ($details['user_immunization_record'] as $ir) {
                    $irDetails .= date('Y', strtotime($ir['upload'])) . "\n";
                }
            }
            $row[] = trim($irDetails);

            // Prepare Grade Card documents
            $gcDetails = '';
            if (!empty($details['user_grade_cards'])) {
                foreach ($details['user_grade_cards'] as $gc) {
                    $gcDetails .= date('Y', strtotime($gc['upload'])) . "\n";
                }
            }
            $row[] = trim($gcDetails);

            // Prepare MDR documents
            $mdrDetails = '';
            if (!empty($details['user_mdr'])) {
                foreach ($details['user_mdr'] as $mdr) {
                    $mdrDetails .= date('Y', strtotime($mdr['upload'])) . "\n";
                }
            }
            $row[] = trim($mdrDetails);

            // Prepare Certificate documents
            $cDetails = '';
            if (!empty($details['user_certificate'])) {
                foreach ($details['user_certificate'] as $c) {
                    $cDetails .= date('Y', strtotime($c['upload'])) . "\n";
                }
            }
            $row[] = trim($cDetails);

            // Prepare Beneficiary Profile documents
            $bpDetails = '';
            if (!empty($details['user_beneficiary_profile'])) {
                foreach ($details['user_beneficiary_profile'] as $bp) {
                    $bpDetails .= date('Y', strtotime($bp['upload'])) . "\n";
                }
            }
            $row[] = trim($bpDetails);

            // Add row to the table
            $this->Row($row);
        }
    }       

}


if (isset($_GET['barangay']) && $_GET['year'] === 'All') {
    $barangay = $_GET['barangay'];

    require_once 'server/display/acsearch_display.php';
 /*   require_once 'server/fetch_data/pdf_acsearch_2.php'; */

    // Create PDF
    $pdf = new PDFALL();
    $pdf->barangay = $barangay;
    $pdf->AdminName = $_SESSION['fname'] . " " . $_SESSION['mname'] . " " . $_SESSION['lname'];
    $pdf->AddPage('L');

    // Ensure $data is correctly populated with the data
    if (isset($data[$barangay])) {
        $pdf->ChapterBody($data[$barangay]);
    } else {
        $pdf->Cell(0, 10, 'No data available for the selected barangay.', 0, 1, 'C');
    }

} 
if (isset($_GET['barangay']) && $_GET['year'] === date('Y')){
    $barangay = $_GET['barangay'];

    // Create PDF
    $pdf = new PDF();
    $pdf->barangay = $barangay . ' - ' . date('Y');
    $pdf->AdminName = $_SESSION['fname'] . " " . $_SESSION['mname'] . " " . $_SESSION['lname'];
    $pdf->AddPage('L');

    require_once 'server/display/acsearch_display.php';

    // Ensure $barangayGroups is correctly populated with the data
    if (isset($barangayGroups[$barangay])) {
        $pdf->ChapterBody($barangayGroups[$barangay]);
    } else {
        $pdf->Cell(0, 10, 'No data available for the selected barangay.', 0, 1, 'C');
    }
}

// Output the PDF
$filename = 'Active_4ps_Reports_' . date('Ymd_His') . '.pdf';
$pdf->Output($filename, 'I');

?>
