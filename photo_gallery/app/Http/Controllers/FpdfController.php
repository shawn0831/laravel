<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// test fpdf
use Fpdf\Fpdf;

class FpdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        // test fpdf 
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World!');
        $pdf->Cell(60,10,'Powered by FPDF.',0,1,'C');
        $pdf = $pdf->Output('test.pdf'.'D');

        return view('test_fpdf.fpdf',[
        ]);
    }

}
