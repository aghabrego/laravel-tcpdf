<?php

namespace Tests\Unit;

use Tests\TestCase;
use Weirdo\TCPDF\TCPDF;
use Weirdo\TCPDF\PDFMerger as PDF;

class MergePDFTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testMergePDF()
    {
        $pdf = new PDF;
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->addPDF(__DIR__ . '/resources/sample-pdf-file.pdf');
        $pdf->addPDF(__DIR__ . '/resources/sample-pdf-with-images.pdf');
        $pdf->merge('file', __DIR__ . '/resources/newfile.pdf');
        $pdf->obEndClean();

        $this->assertFileExists(__DIR__ . '/resources/newfile.pdf');
    }

    public function testMergePDFWithTCPDF()
    {
        $pdf = new TCPDF();
        $pdf->addPDF(__DIR__ . '/resources/sample-pdf-file.pdf');
        $pdf->addPDF(__DIR__ . '/resources/sample-pdf-with-images.pdf');
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->merge('file', __DIR__ . '/resources/newfile2.pdf');
        $pdf->obEndClean();

        $this->assertFileExists(__DIR__ . '/resources/newfile2.pdf');
    }

    public function testConvertPDFVersion()
    {
        $pdf = new PDF;
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->addPDF(__DIR__ . '/resources/dMAT7zyG.pdf');
        $pdf->addPDF(__DIR__ . '/resources/sample-pdf-create.pdf');
        $pdf->merge('file', __DIR__ . '/resources/newfile3.pdf', true);
        $pdf->obEndClean();

        $this->assertFileExists(__DIR__ . '/resources/newfile3.pdf');
    }

    public function testSwitchmode()
    {
        $pdf = new TCPDF();
        $type = $pdf->switchmode('F');
        $this->assertEquals($type, 'file');
    }
}
