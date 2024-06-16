<?php

namespace Weirdo\TCPDF\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method void SetConfig()
 * @method void Header()
 * @method void Footer()
 * @method void setPrintHeader($val = true)
 * @method void setPrintFooter($val = true)
 */
class TcpdfFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tcpdf';
    }
}