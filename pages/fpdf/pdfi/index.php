<?php
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

require_once('fpdf/fpdf.php');
require_once('fpdi2/src/autoload.php');

$pdf = new Fpdi();

$pageCount = $pdf->setSourceFile('sample.pdf');
$pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);

$pdf->addPage();
$pdf->useImportedPage($pageId, 10, 10, 90);

$pdf->Output();