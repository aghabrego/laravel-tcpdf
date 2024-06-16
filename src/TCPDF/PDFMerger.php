<?php

namespace Weirdo\TCPDF;

use Exception;
use Weirdo\TCPDF\Device\PDF;
use setasign\Fpdi\Tcpdf\Fpdi;
use Weirdo\TCPDF\Device\PDFToHTML;
use Org_Heigl\Ghostscript\Ghostscript;

class PDFMerger extends Fpdi
{
    /**
     * @var array
     */
    private $_files; //['form.pdf']  ["1,2,4, 5-19"]

    /**
     * Current page orientation (P = Portrait, L = Landscape).
     * @protected
     */
    protected $curOrientation;

    /**
     * @var Ghostscript
     */
    protected $gs;

    /**
     * @var PDFToHTML
     */
    private $_toHTML;

    /**
     * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or Portrait (default)</li><li>L or Landscape</li><li>'' (empty string) for automatic orientation</li></ul>
     * @param $unit (string) User measure unit. Possible values are:<ul><li>pt: point</li><li>mm: millimeter (default)</li><li>cm: centimeter</li><li>in: inch</li></ul><br />A point equals 1/72 of inch, that is to say about 0.35 mm (an inch being 2.54 cm). This is a very common unit in typography; font sizes are expressed in that unit.
     * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
     * @param $unicode (boolean) TRUE means that the input text is unicode (default = true)
     * @param $encoding (string) Charset encoding (used only when converting back html entities); default is UTF-8.
     * @param $diskcache (boolean) DEPRECATED FEATURE
     * @param $pdfa (integer) If not false, set the document to PDF/A mode and the good version (1 or 3).
     * @param $usefpdi (boolean)TRUE means the default FpdiTCPDFHelper classes will be used (default = true) and false means the TCPDFHelper class will be used.
     * @public
     * @see getPageSizeFromFormat(), setPageFormat()
     */
    public function __construct(
        $orientation = 'P',
        $unit = 'mm',
        $format = 'A4',
        $unicode = true,
        $encoding = 'UTF-8',
        $diskcache = false,
        $pdfa = false,
        $usefpdi = true
    ) {
        if (is_callable('parent::__construct')) {
            parent::__construct(
                $orientation,
                $unit,
                $format,
                $unicode,
                $encoding,
                $diskcache,
                $pdfa,
                $usefpdi
            );
        }

        $this->curOrientation = $orientation;
        $this->gs = new Ghostscript();
    }

    /**
     * Add a PDF for inclusion in the merge with a valid file path. Pages should be formatted: 1,3,6, 12-16.
     * @param string $filepath
     * @param string $pages
     * @return PDFMerger
     */
    public function addPDF($filepath, $pages = 'all')
    {
        if (file_exists($filepath)) {
            if (strtolower($pages) != 'all') {
                $pages = $this->_rewritepages($pages);
            }

            $this->_files[] = array($filepath, $pages);
        } else {
            throw new Exception("Could not locate PDF on '$filepath'");
        }

        return $this;
    }

    /**
     * Add a PDF to include in the conversion to html
     * @param string $filepath
     * @return PDFToHTML
     */
    public function addPDFToConvert($filepath)
    {   
        if (file_exists($filepath)) {
            $this->_toHTML = new PDFToHTML($filepath);
        } else {
            throw new Exception("Could not locate PDF on '$filepath'");
        }

        return $this;
    }

    /**
     * Merges your provided PDFs and outputs to specified location.
     * @param string $outputmode
     * @param string $outputpath
     * @param boolean $convert
     * @return mixed
     */
    public function merge($outputmode = 'browser', $outputpath = 'newfile.pdf', $convert = false)
    {
        if (!isset($this->_files) || !is_array($this->_files)) :
            throw new exception("No PDFs to merge.");
        endif;

        try {
            if ($convert == true) {
                $this->optimizePDFVersion();
            }

            //merger operations
            foreach ($this->_files as $file) {
                $filename = $file[0];
                $filepages = $file[1];
                $count = $this->setSourceFile($filename);

                //add the pages
                if ($filepages == 'all') {
                    for ($i = 1; $i <= $count; $i++) {
                        $template = $this->importPage($i);
                        $size = $this->getTemplateSize($template);
                        $this->AddPage($this->curOrientation, array($size['width'], $size['height']));
                        $this->useTemplate($template, 0, 0, $size['width'], $size['height'], false);
                    }
                } else {
                    foreach ($filepages as $page) {
                        if (!$template = $this->importPage($page)) {
                            throw new exception("Impossible to load the '$page' in the PDF called '$filename'. Check that the page exists.");
                        }

                        $size = $this->getTemplateSize($template);
                        $this->AddPage($this->curOrientation, array($size['width'], $size['height']));
                        $this->useTemplate($template, 0, 0, $size['width'], $size['height'], false);
                    }
                }
            }
        } catch (Exception $e) {
            printf("Some files use some unknown formats. It is not possible to create the final pdf file.");
        }

        //output operations
        $mode = $this->_switchmode($outputmode);

        return $this->Output($outputpath, $mode);
    }

    /**
     * FPDI uses single characters for specifying the output location. Change our more descriptive string into proper format.
     * @param $mode
     * @return string
     */
    private function _switchmode($mode)
    {
        switch (strtolower($mode)) {
            case 'download':
                return 'D';
                break;
            case 'browser':
                return 'I';
                break;
            case 'file':
                return 'F';
                break;
            case 'string':
                return 'S';
                break;
            default:
                return 'I';
                break;
        }
    }

    /**
     * Takes our provided pages in the fotcrm of 1,3,4,16-50 and creates an array of all pages
     * @param $pages
     * @return unknown_type
     */
    private function _rewritepages($pages)
    {
        $pages = str_replace(' ', '', $pages);
        $part = explode(',', $pages);

        //parse hyphens
        foreach ($part as $i) {
            $ind = explode('-', $i);

            if (count($ind) == 2) {
                $x = $ind[0]; //start page
                $y = $ind[1]; //end page

                if ($x > $y) : throw new exception("Starting page, '$x' is greater than ending page '$y'.");
                    return false;
                endif;

                //add middle pages
                while ($x <= $y) : $newpages[] = (int)$x;
                    $x++;
                endwhile;
            } else {
                $newpages[] = (int)$ind[0];
            }
        }

        return $newpages;
    }

    /**
     * @param string|SplFileInfo $file
     * @return string
     */
    public function parsetPDF($file)
    {
        /** @var string */
        $name = str_random(40);
        /** @var string */
        $filename = "/tmp/{$name}.pdf";
        $this->gs->setDevice(new PDF)
            ->setInputFile($file)
            ->setOutputFile($filename)
            ->render();

        /** @var string */
        $output = $this->gs->getOutputFile();

        return $output;
    }

    /**
     * Change the PDF version dynamically.
     * @return void
     */
    public function optimizePDFVersion()
    {
        foreach ($this->_files as $index => $file) {
            /** @var string */
            $output = $this->parsetPDF($file[0]);
            $this->_files[$index][0] = $output;
        }
    }

    /**
     * @return array
     */
    public function convertPDFtoHTML()
    {
        $html = $this->_toHTML->getHtml()->getAllPages();

        return $html;
    }

    /**
     * @return string
     */
    public function unifyConvertedHTML()
    {
        $html = $this->_toHTML->getHtml()->unifyHTML();

        return $html;
    }

    /**
     * To specify the output location. Change our most descriptive string to the proper format.
     * @param string $mode
     * @return string
     */
    public function switchmode(string $mode)
    {
        switch ($mode) {
            case 'D':
                return 'download';
                break;
            case 'I':
                return 'browser';
                break;
            case 'F':
                return 'file';
                break;
            case 'S':
                return 'string';
                break;
            default:
                return 'I';
                break;
        }
    }

    /**
     * @return void
     */
    public function obEndClean(): void
    {
        if (ob_get_contents()) {
            ob_end_clean();
        }
        if (ob_get_length()) {
            ob_end_clean();
        }
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
