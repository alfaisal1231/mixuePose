<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function generatePdf()
    {
        $mpdf = new Mpdf();

        // Load HTML content
        $html = view('pdf_template')->render();
        $mpdf->WriteHTML($html);

        // Output the PDF as a download
        $mpdf->Output('document.pdf', 'D');
    }
}
