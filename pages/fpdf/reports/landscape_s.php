<?php // RAY_fpdf_hello_world_landscape.php


// DEMONSTRATE THE BASICS OF FPDF


// BRING IN THE PDF THING
require_once('../fpdf.php');


// SYNTHESIZE THE PDF FILE INFORMATION
$pdf_file_link = '/RAY_junk/' . 'temp_pdf_blue' . '.pdf';
$pdf_file_name = getcwd()     . $pdf_file_link;

// DO THE HELLO WORLD EXERCISE IN WHITE ON A BLUE BACKGROUND
$pdf=new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetFillColor(  0,   0, 255);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 10, 'Hello World!', 0, 2, 'L', TRUE);

// WRITE THE PDF TO DISK
$pdf->Output($pdf_file_name, 'F');

// PRESENT A LINK
echo '<a target="my_PDF" href="' . $pdf_file_link . '">Blue PDF</a>';


// START OVER FOR A NEW PDF
unset($pdf);
echo PHP_EOL . "<br/>";

// SYNTHESIZE THE PDF FILE INFORMATION
$pdf_file_link = '/RAY_junk/' . 'temp_pdf_red' . '.pdf';
$pdf_file_name = getcwd()     . $pdf_file_link;

// DO THE HELLO WORLD EXERCISE IN WHITE ON A RED BACKGROUND
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetFillColor(255,   0,   0);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 10, 'Hello World!', 0, 2, 'L', TRUE);

// WRITE THE PDF TO DISK
$pdf->Output($pdf_file_name, 'F');

// PRESENT A LINK
echo '<a target="my_PDF" href="' . $pdf_file_link . '">Red PDF</a>';