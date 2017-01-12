<?php
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class Pdfs extends CI_Controller {

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
        header('Content-type: application/json');
        try{
            $pdf->Output($name, 'F');
            echo json_encode( array('status' => true ) );
            exit;            
        } catch(Exception $ex){
            echo json_encode( array('status' => false ) );
            exit;
        }
    }
}