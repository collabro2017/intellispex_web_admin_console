<?php
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Pdfs extends CI_Controller {

/*
 * @param $dest (string) Destination where to send the document. It can take one of the following values:
 * <ul><li>I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.</li>
 * <li>D: send to the browser and force a file download with the name given by name.</li>
 * <li>F: save to a local server file with the name given by name.</li>
 * <li>S: return the document as a string (name is ignored).</li>
 * <li>FI: equivalent to F + I option</li>
 * <li>FD: equivalent to F + D option</li>
 * <li>E: return the document as base64 mime multi-part email attachment (RFC 2045)</li></ul>
 *
 */

	public function init()
    {
        $this->load->library('pdf');
        $html = $this->input->post()['html'];

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('ICYMI');
        $pdf->SetTitle('REPORT');
        $pdf->SetSubject('REPORT');
        $pdf->SetKeywords('REPORT');
 
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
 
        $pdf->setFontSubsetting(true);
 
        $pdf->AddPage();

        $pdf->writeHTML($html, true, false, true, false, '');
 
        $name = FCPATH.'report/'. utf8_decode("report_usagestatistics.pdf");

        try{

            $pdf->Output($name, 'F');
            echo json_encode( array('status' => true ) );
            exit;
        } catch(Exception $ex){
            echo json_encode( array('status' => false ) );
            exit;
        }
    }

    public function download()
	{
		$this->load->library('pdf');
		$html = $this->input->post('html');
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('ICYMI');
		$pdf->SetTitle('REPORT');
		$pdf->SetSubject('REPORT');
		$pdf->SetKeywords('REPORT');

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		$pdf->setFontSubsetting(true);

		$pdf->AddPage();

		$pdf->writeHTML($html, true, false, true, false, '');

		$name = FCPATH.'report/'. utf8_decode("report_usagestatistics.pdf");

		try{
			$pdf->Output($name, 'D');
		} catch(Exception $ex){
			echo 'Report can not be download';
		}
		exit;
	}
}