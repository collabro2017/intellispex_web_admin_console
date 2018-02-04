<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
// create new PDF document
class Pdf extends TCPDF {
	//Page header
        function __construct()
        {
            parent::__construct();
        }
//	public function Header() {
//		// get the current page break margin
//		$bMargin = $this->getBreakMargin();
//		// get current auto-page-break mode
//		$auto_page_break = $this->AutoPageBreak;
//		// disable auto-page-break
//		$this->SetAutoPageBreak(false, 0);
//		// set bacground image
//		$img_file = K_PATH_IMAGES.'bg.jpg';
//		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
//		// restore auto-page-break status
//		$this->SetAutoPageBreak($auto_page_break, $bMargin);
//		// set the starting point for the page content
//		$this->setPageMark();
//	}

	// Colored table
//	public function EmployeeTable($header,$data) {
//		// Colors, line width and bold font
//		$this->SetFillColor(248, 247, 247);
//		$this->SetTextColor(40,89,155);
//		$this->SetDrawColor(221);
//		$this->SetLineWidth(0);
//		$this->SetFont('', '','9');
//		// Header
//		$w = array(21, 40, 24,22,38);
//		$num_headers = count($header);
//		for($i = 0; $i < $num_headers; ++$i) {
//			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'L', 1);
//		}
//		$this->Ln();
//		// Color and font restoration
//		$this->SetFillColor(248, 247, 247);
//		$this->SetTextColor(0);
//		$this->SetFont('', '','7');
//		// Data
//		$fill = 0;
//		foreach($data as $row) {
//			$this->Cell($w[0], 6, $row[0]." ". $row[1], 'LR', 0, 'L', $fill);
//			$this->Cell($w[1], 6, $row[2], 'LR', 0, 'L', $fill);
//			$this->Cell($w[2], 6, $row[3], 'LR', 0, 'L', $fill);
//			$this->Cell($w[3], 6, $row[4], 'LR', 0, 'L', $fill);
//			$this->Cell($w[4], 6, $row[5]." ".$row[6], 'LR', 0, 'L', $fill);
//			$this->Ln();
//			$fill=!$fill;
//		}
//		$this->Cell(array_sum($w), 0, '', 'T');
//	}
        
        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
//            $this->SetFont('helvetica', 'I', 8);
            // Page number
            
            
            if(isset($_SESSION['RightText'])){
                $this->Cell(0, 10, $_SESSION['RightText'], 0, false, 'L', 0, '', 0, false, 'T', 'M');
            }
            
            $this->Cell(0, 10, "Page ". $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            
            
            if(isset($_SESSION['CenterText'])){
                $this->Cell(0, 10, $_SESSION['CenterText'], 0, false, 'R', 0, '', 0, false, 'C', 'M');
            }
        }
        public function preferences($pdf){
            // set font
            $pdf->SetFont('helvetica', '', 14);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);

            // set default header data
//            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                    require_once(dirname(__FILE__).'/lang/eng.php');
                    $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set array for viewer preferences
            $preferences = array(
                    'HideToolbar' => true,
                    'HideMenubar' => true,
                    'HideWindowUI' => true,
                    'FitWindow' => true,
                    'CenterWindow' => true,
                    'DisplayDocTitle' => true,
                    'NonFullScreenPageMode' => 'UseNone', // UseNone, UseOutlines, UseThumbs, UseOC
                    'ViewArea' => 'CropBox', // CropBox, BleedBox, TrimBox, ArtBox
                    'ViewClip' => 'CropBox', // CropBox, BleedBox, TrimBox, ArtBox
                    'PrintArea' => 'CropBox', // CropBox, BleedBox, TrimBox, ArtBox
                    'PrintClip' => 'CropBox', // CropBox, BleedBox, TrimBox, ArtBox
                    'PrintScaling' => 'AppDefault', // None, AppDefault
                    'Duplex' => 'DuplexFlipLongEdge', // Simplex, DuplexFlipShortEdge, DuplexFlipLongEdge
                    'PickTrayByPDFSize' => true,
                    'PrintPageRange' => array(1,1,2,3),
                    'NumCopies' => 2
            );

            $pdf->setViewerPreferences($preferences);
        }
}
 
//class Pdf extends TCPDF
//{
//    
//}
// 
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */