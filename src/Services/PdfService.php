<?php

namespace App\Services;
use Dompdf\Css\Stylesheet;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $domPdf;

    public function __construct(){


        $pdfOptions=new Options();

        $pdfOptions->set('defaultFont','Arial');


        $this->domPdf=new Dompdf($pdfOptions);




    }

    public function showPfFile($html){

        $this->domPdf->loadHtml($html);
        $this->domPdf->setPaper('A3','portrait');

        $this->domPdf->render();
        $output =$this->domPdf->output();

       file_put_contents('E:/Federation-de-football/public/mypdf.pdf',$output);

    }

    public function generateBinaryPDF($html){
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->output();
    }

}