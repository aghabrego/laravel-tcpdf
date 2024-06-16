<?php

namespace Weirdo\TCPDF;

use SplFileInfo;
use ReflectionClass;
use Weirdo\TCPDF\TCPDFHelper;
use Weirdo\TCPDF\FpdiTCPDFHelper;

class TCPDF
{
    /**
     * @var mixed
     */
    protected static $format;

    /**
     * @var TCPDFHelper|FpdiTCPDFHelper
     */
    protected $tcpdf;

    /**
     * @var string
     */
    private $__orientation;

    /**
     * @var string
     */
    private $__unit;

    /**
     * @var mixed
     */
    private $__format;

    /**
     * @var boolean
     */
    private $__unicode;

    /**
     * @var string
     */
    private $__encoding;

    /**
     * @var boolean
     */
    private $__diskcache;

    /**
     * @var integer|false
     */
    private $__pdfa;

    /**
     * @var boolean
     */
    private $__usefpdi;

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
        $this->__orientation = $orientation;
        $this->__unit = $unit;
        $this->__format = $format;
        $this->__unicode = $unicode;
        $this->__encoding = $encoding;
        $this->__diskcache = $diskcache;
        $this->__pdfa = $pdfa;
        $this->__usefpdi = $usefpdi;

        $this->reset();
    }

    public function reset()
    {
        $class = $this->__usefpdi ? FpdiTCPDFHelper::class : TCPDFHelper::class;
        $this->tcpdf = new $class(
            $this->__orientation ?? 'P',
            $this->__unit ?? 'mm',
            static::$format ? static::$format : $this->__format,
            $this->__unicode,
            $this->__encoding ?? 'UTF-8',
            $this->__diskcache,
            $this->__pdfa
        );
    }

    public static function changeFormat($format)
    {
        static::$format = $format;
    }

    public function __call($method, $args)
    {
        $reflection = new ReflectionClass($this->tcpdf);
        if ($reflection->hasMethod($method)) {
            return call_user_func_array([$this->tcpdf, $method], $args);
        }

        throw new \RuntimeException(sprintf('the method %s does not exists in TCPDF', $method));
    }

    public function setHeaderCallback($headerCallback)
    {
        $this->tcpdf->setHeaderCallback($headerCallback);
    }

    public function setFooterCallback($footerCallback)
    {
        $this->tcpdf->setFooterCallback($footerCallback);
    }

    /**
     * @param string $path
     * @return int
     */
    public function getCountPDFPages(string $path)
    {
        /** @var string $result */
        $result = $this->tcpdf->optimizePDFversion($path);
        /** @var int $documento */
        $documento = $this->tcpdf->setSourceFile($result);

        return $documento;
    }

    /**
     * @param string $file
     * @return PDFMerger
     */
    public function addPDFToConvert(string $file)
    {
        return $this->tcpdf->addPDFToConvert($file);
    }

    /**
     * @return array
     */
    public function convertPDFtoHTML()
    {
        return $this->tcpdf->convertPDFtoHTML();
    }

    /**
     * @return string
     */
    public function unifyConvertedHTML()
    {
        return $this->tcpdf->unifyConvertedHTML();
    }

    /**
     * @param string $mode
     * @return string
     */
    public function switchmode(string $mode)
    {
        return $this->tcpdf->switchmode($mode);
    }

    /**
     * @return void
     */
    public function obEndClean(): void
    {
        $this->tcpdf->obEndClean();
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function getPDFWidthAndHeight(string $path)
    {
        if (!method_exists($this->tcpdf, 'getPDFWidthAndHeight')) {
            return false;
        }

        return $this->tcpdf->getPDFWidthAndHeight($path);
    }

    /**
     * @param string $filepath
     * @param string $pages
     * @return PDFMerger
     */
    public function addPDF($filepath, $pages = 'all')
    {
        return $this->tcpdf->addPDF($filepath, $pages);
    }

    /**
     * @param string $outputmode
     * @param string $outputpath
     * @param boolean $convert
     * @return mixed
     */
    public function merge($outputmode = 'browser', $outputpath = 'newfile.pdf', $convert = false)
    {
        return $this->tcpdf->merge($outputmode, $outputpath, $convert);
    }

    /**
     * @param string|SplFileInfo $file
     * @return string
     */
    public function optimizePDFversion($file)
    {
        return $this->tcpdf->optimizePDFversion($file);
    }
}
