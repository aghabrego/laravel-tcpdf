<?php

namespace Weirdo\TCPDF;

use SplFileInfo;
use Weirdo\TCPDF\PDFMerger;
use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Support\Facades\Config;

class FpdiTCPDFHelper extends Fpdi
{
    protected $headerCallback;

    protected $footerCallback;

    /**
     * @var PDFMerger
     */
    protected $pdfMerge;

    protected $PDFVersion;

    /**
     * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or Portrait (default)</li><li>L or Landscape</li><li>'' (empty string) for automatic orientation</li></ul>
     * @param $unit (string) User measure unit. Possible values are:<ul><li>pt: point</li><li>mm: millimeter (default)</li><li>cm: centimeter</li><li>in: inch</li></ul><br />A point equals 1/72 of inch, that is to say about 0.35 mm (an inch being 2.54 cm). This is a very common unit in typography; font sizes are expressed in that unit.
     * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
     * @param $unicode (boolean) TRUE means that the input text is unicode (default = true)
     * @param $encoding (string) Charset encoding (used only when converting back html entities); default is UTF-8.
     * @param $diskcache (boolean) DEPRECATED FEATURE
     * @param $pdfa (integer) If not false, set the document to PDF/A mode and the good version (1 or 3).
     * @public
     * @see getPageSizeFromFormat(), setPageFormat()
     */
    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
    {
        if (is_callable('parent::__construct')) {
            parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
        }

        $this->pdfMerge = new PDFMerger($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }

    public function SetConfig()
    {
        //
    }

    public function Header()
    {
        if ($this->headerCallback != null && is_callable($this->headerCallback)) {
            $cb = $this->headerCallback;
            $cb($this);
        } else {
            if (Config::get('tcpdf.use_original_header')) {
                parent::Header();
            }
        }
    }

    public function Footer()
    {
        if ($this->footerCallback != null && is_callable($this->footerCallback)) {
            $cb = $this->footerCallback;
            $cb($this);
        } else {
            if (Config::get('tcpdf.use_original_footer')) {
                parent::Footer();
            }
        }
    }

    public function setHeaderCallback($callback)
    {
        $this->headerCallback = $callback;
    }

    public function setFooterCallback($callback)
    {
        $this->footerCallback = $callback;
    }

    /**
     * @param string $filepath
     * @param string $pages
     * @return PDFMerger
     */
    public function addPDF($filepath, $pages = 'all')
    {
        return $this->pdfMerge->addPDF($filepath, $pages);
    }

    /**
     * @param string $outputmode
     * @param string $outputpath
     * @param boolean $convert
     * @return mixed
     */
    public function merge($outputmode = 'browser', $outputpath = 'newfile.pdf', $convert = false)
    {
        return $this->pdfMerge->merge($outputmode, $outputpath, $convert);
    }

    /**
     * @param string|SplFileInfo $file
     * @return string
     */
    public function optimizePDFversion($file)
    {
        return $this->pdfMerge->parsetPDF($file);
    }

    /**
     * @param string $file
     * @return PDFMerger
     */
    public function addPDFToConvert(string $file)
    {
        return $this->pdfMerge->addPDFToConvert($file);
    }

    /**
     * @return array
     */
    public function convertPDFtoHTML()
    {
        return $this->pdfMerge->convertPDFtoHTML();
    }

    /**
     * @return string
     */
    public function unifyConvertedHTML()
    {
        return $this->pdfMerge->unifyConvertedHTML();
    }

    /**
     * @param string $mode
     * @return string
     */
    public function switchmode(string $mode)
    {
        return $this->pdfMerge->switchmode($mode);
    }

    /**
     * @return void
     */
    public function obEndClean(): void
    {
        $this->pdfMerge->obEndClean();
    }

    /**
     * @param string $path
     * @return array
     */
    public function getPDFWidthAndHeight(string $path)
    {
        /** @var string $result */
        $result = $this->optimizePDFversion($path);
        $this->setSourceFile($result);

        $pageId = 1;
        /** @var string $sid */
        $sid = $this->importPage($pageId);
        /** @var array|bool $originalSize */
        $originalSize = $this->getTemplateSize($sid);
        
        return $originalSize;
    }
}
