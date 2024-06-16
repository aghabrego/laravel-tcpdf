<?php

namespace Tests\Unit;

use DOMDocument;
use Tests\TestCase;
use Weirdo\TCPDF\TCPDF;
use Weirdo\Helper\BaseClass;

class PDFTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testPDF()
    {
        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->setMargins(14, 10, 14);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();
        $html = file_get_contents(__DIR__ . '/resources/fhCcXJ92Oc0QMvwi8cfy5sA3N0fw9H8v.html');
        $pdf->writeHTML($html, true, false, true, true, '');
        $pdf->setFooterCallback(function ($pdf) {
            $pdf->SetX(10);
            $pdf->SetY(260);
            $pdf->Cell(50, 10, $pdf->getAliasRightShift() . 'Hola Mundo', true, 0, 'R');
        });
        $pdf->lastPage();
        $pdf->Output(__DIR__ . '/resources/sample-pdf-create.pdf', 'F');

        $this->assertFileExists(__DIR__ . '/resources/sample-pdf-create.pdf');
    }

    public function testCountPDFPages()
    {
        $path = __DIR__ . '/resources/sample-pdf-with-images.pdf';
        $base = new TCPDF();
        $result = $base->getCountPDFPages($path);
        $this->assertEquals(10, $result);

        $path = __DIR__ . '/resources/generated.pdf';
        $result = $base->getCountPDFPages($path);
        $this->assertEquals(1, $result);
    }

    public function testConvertPDFtoHTML()
    {
        $path = __DIR__ . '/resources/sample-pdf-create.pdf';
        $base = new TCPDF();
        $base->addPDFToConvert($path);
        /** @var array<string> $htmls */
        $htmls = $base->convertPDFtoHTML();
        $dom = new DOMDocument();
        foreach ($htmls as $html) {
            $dom->loadHTML($html);
        }
        $dom->save(__DIR__ . '/resources/sample-pdf-create.html');
        $this->assertFileExists(__DIR__ . '/resources/sample-pdf-create.html');
    }

    public function testUnifyConvertedHTML()
    {
        $path = __DIR__ . '/resources/0101010_GP_criptoy13gmail.com.pdf';
        $base = new TCPDF();
        $base->addPDFToConvert($path);
        $html = $base->unifyConvertedHTML();
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $dom->save(__DIR__ . '/resources/0101010_GP_criptoy13gmail.com.html');
        $this->assertFileExists(__DIR__ . '/resources/0101010_GP_criptoy13gmail.com.html');

        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->setMargins(14, 10, 14);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();
        $pdf->setFooterCallback(function ($pdf) {
            
        });
        $html = file_get_contents(__DIR__ . '/resources/0101010_GP_criptoy13gmail.com.html');
        $pdf->writeHTML($html, true, false, true, true, '');
        $pdf->lastPage();
        $pdf->Output(__DIR__ . '/resources/0101010_GP_criptoy13gmail.com.nuevo.pdf', 'F');
        

        $this->assertFileExists(__DIR__ . '/resources/0101010_GP_criptoy13gmail.com.nuevo.pdf');
    }

    public function testPDFWidthAndHeight()
    {
        $helper = new BaseClass();
        $pdf = new TCPDF();
        $dir = $helper->getDirname(__DIR__, 1);
        $resultPath = $helper->getSystemRoute($dir, "/Unit/resources/0101010_GP_criptoy13gmail.com.pdf");
        $detail = $pdf->getPDFWidthAndHeight($resultPath);

        $this->assertIsArray($detail);
        $this->assertArrayHasKey('width', $detail);
        $this->assertArrayHasKey('height', $detail);
    }

    public function testCreatePDFFromHtml()
    {
        $helper = new BaseClass();
        $pdf = new TCPDF();
        $html = <<<"EOD"
        <!DOCTYPE html>
        <html lang="es">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
                <meta name="csrf-token" content="644krl8lJb9bsDjnOotXXGZ79j2tO0ah1ipNlaKE">
                <title>Completo365</title>

                
                <!-- Styles -->
                <style>
                    body {
                    font-size: 12px;
                    }

                    p,
                    dd {
                    text-align: justify;
                    }

                    strong,
                    h2,
                    h3,
                    h4,
                    h5 {
                    text-transform: uppercase;
                    }

                    h1,
                    h2,
                    h3,
                    h4,
                    h5,
                    h6,
                    .textoCentreado {
                    text-align: center;
                    }

                    table tr td {
                    border: 1px solid black;
                    }

                    table {
                    width: 100%;
                    }

                    .textoVertical {
                    vertical-align: middle;
                    }
                </style>
            </head>
            <body>
                <style>
                    .bodyWeb {
                        font-size: 2.2vw;
                    }
                    .h4Web {
                        font-size: 3.5vw;
                    }
                    .h3Web {
                        font-size: 3.8vw;
                    }
                    p {
                        text-align: justify;
                    }
                    p, table {
                        margin-bottom: 1em;
                    }
                    table tr td {
                        border: 1px solid black;
                    }
                    table {
                        width: 100%;
                    }
                    h1,
                    h2,
                    h3,
                    h4,
                    h5,
                    h6,
                    .textoCentreado {
                        text-align: center;
                    }

                    .textoVertical {
                        vertical-align: middle;
                    }
                </style>
            <div class="">
            <h3 class="">Contrato de Promesa de Compraventa</h3>
            <p>
                Este contrato de Promesa de Compraventa está compuesto por dos partes, una General (A) y una de
                condiciones particulares (B). EL PROMITENTE VENDEDOR le requiere que lea el contrato detenidamente
                antes de firmarlo y haga los cuestionamientos que necesite antes de la firma; con su firma, queda
                validado que su consentimiento en este contrato es “informado”.
            </p>
            <h4 class="">Parte A: Condiciones Generales</h4>
            <table style="width: 100%;">
                <tr>
                    <td rowspan="22" style="width: 3%;"><p class="textoVertical">PARTES</p></td>
                    <td colspan="8" style="width: 97%;" class="textoCentreado">PROMITENTE VENDEDOR<br></td>
                </tr>
                <tr>
                    <td style="width: 28%">Razón Social</td>
                    <td colspan="7" style="width: 69%;"><strong>Hawthorne Assets Corp</strong></td>
                </tr>
                <tr>
                    <td class="textoVertical">Datos de Inscripción:</td>
                    <td style="width: 8%">Ficha</td>
                    <td style="width: 11%"><strong>155640474</strong></td>
                    <td style="width: 7%">Tomo</td>
                    <td style="width: 10%"><strong></strong></td>
                    <td style="width: 13%">Rollo</td>
                    <td style="width: 10%"><strong></strong></td>
                    <td style="width: 10%"></td>
                </tr>
                <tr>
                    <td>Datos de Representante Legal</td>
                    <td colspan="1">Nombre</td>
                    <td colspan="3"><strong>Gilma Estela Ho de Herrera</strong></td>
                    <td>Cédula</td>
                    <td colspan="2"><strong>82581002</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Celular</td>
                    <td colspan="2"><strong>66794527</strong></td>
                    <td>Tel. Oficina</td>
                    <td colspan="2"><strong>2026977</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Correo Electrónico</td>
                    <td colspan="5"><strong>contratos@grupoprodecasa.com</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Dirección</td>
                    <td colspan="5"><strong>Panamá</strong></td>
                </tr>
                <tr>
                    <td colspan="8" class="textoCentreado">PROMITENTE COMPRADOR<br></td>
                </tr>
                <tr>
                    <td>PROMITENTE COMPRADOR 1</td>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="1">Nombre</td>
                    <td colspan="3"><strong>Marcelino Ruiz</strong></td>
                    <td>Cédula/Pasp.</td>
                    <td colspan="2"><strong>8453121</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Celular</td>
                    <td colspan="2"><strong>61878744</strong></td>
                    <td>Teléfono R.</td>
                    <td colspan="2"><strong></strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Teléfono de Of.</td>
                    <td colspan="2"><strong></strong></td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Correo Electrónico</td>
                    <td colspan="5"><strong>Marcellr20@gmail.com</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Dirección</td>
                    <td colspan="5"><strong></strong></td>
                </tr>
                <tr>
                    <td>PROMITENTE COMPRADOR 2</td>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="1">Nombre</td>
                    <td colspan="3"></td>
                    <td>Cédula/Pasp.</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Celular</td>
                    <td colspan="2"></td>
                    <td>Teléfono R.</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Teléfono de Of.</td>
                    <td colspan="2"></td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Correo Electrónico</td>
                    <td colspan="5"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">Dirección</td>
                    <td colspan="5"></td>
                </tr>
                <tr>
                    <td>LAS PARTES</td>
                    <td colspan="7">Termino a usarse para identificar a todas las partes del contrato.</td>
                </tr>
                <tr>
                    <td colspan="8">En adelante se usará el término PROMITENTE COMPRADOR para designar al singular y el plural,
                    al masculino y el femenino.
                    </td>
                </tr>
            </table>
            <h1></h1>
            <table>
                <tr>
                <td rowspan="13" style="width: 3%">OBJETO</td>
                <td colspan="5" style="width: 97%">EL PROMITENTE VENDEDOR promete que venderá a EL PROMITENTE COMPRADOR, y este promete que comprará,
                    el lote y sus mejoras (referidos en adelante como LA FINCA) que resulten luego de la segregación
                    de la Finca Madre. EL PROMITENTE VENDEDOR se obliga a vender la FINCA libre de gravámenes y se
                    compromete al Saneamiento en caso de evicción.  Los datos de la FINCA MADRE y la FINCA incluyendo
                    sus mejoras se describen a continuación.
                </td>
                </tr>
                <tr>
                <td colspan="2" style="width: 35%">FINCA MADRE</td>
                <td colspan="3" style="width: 62%"><strong>Folio Real cuarenta y dos mil cuatrocientos cincuenta y uno (42451), Tomo mil veintitrés (1023), Folio Doscientos cuarenta y seis (246) de la Sección de Propiedad, Provincia de Panamá del Registro Público</strong></td>
                </tr>
                <tr>
                <td colspan="2">NOMBRE DEL PROYECTO</td>
                <td colspan="3"><strong>Green Park</strong></td>
                </tr>
                <tr>
                <td colspan="5" class="textoCentreado">DATOS DE LA FINCA</td>
                </tr>
                <tr>
                <td colspan="2"></td>
                <td colspan="3"></td>
                </tr>
                <tr>
                <td colspan="2">MODELO DE LA CASA</td>
                <td colspan="3"><strong>Isabel</strong></td>
                </tr>
                <tr>
                <td colspan="2">METRAJE DEL LOTE</td>
                <td colspan="3"><strong>160.00 m<sup>2</sup></strong></td>
                </tr>
                <tr>
                <td colspan="2">UBICACIÓN</td>
                <td colspan="3">LAS PARTES acuerdan que puede variar según entendimiento desarrollado en la
                    cláusula 5 de condiciones particulares
                </td>
                </tr>
                <tr>
                <td colspan="2">SUPERFICIE (AREA ABIERTA)</td>
                <td colspan="3"><strong>13.00 m<sup>2</sup></strong></td>
                </tr>
                <tr>
                <td colspan="2">SUPERFICIE (AREA CERRADA)</td>
                <td colspan="3"><strong>50.00 m<sup>2</sup></strong></td>
                </tr>
                <tr>
                <td colspan="2">GARAJE / ESTACIONAMIENTOS</td>
                <td colspan="3"><strong>Garaje sin techar</strong></td>
                </tr>
                <tr>
                <td rowspan="2">DISTRIBUCIÓN:</td>
                <td>Número de Cuartos</td>
                <td><strong>2</strong></td>
                <td>Número de Baños</td>
                    <td><strong>1</strong></td>
                </tr>
                <tr>
                <td colspan="4">Vivienda unifamiliar de una planta que consta de sala-comedor, cocina, área de
                    lavandería / No incluye Lámparas</td>
                </tr>
            </table>
            <h1></h1>
            <table>
                <tr>
                <td rowspan="19" style="width: 3%">PRECIO</td>
                <td colspan="5" style="width: 97%">EL PROMITENTE COMPRADOR se obliga a pagar a EL PROMITENTE VENDEDOR el precio
                    descrito a continuación y en la forma que aquí se pacta:
                </td>
                </tr>
                <tr>
                <td colspan="5" class="textoCentreado">PRECIO DE VENTA</td>
                </tr>
                <tr>
                <td>En Letras</td>
                <td colspan="4"><strong>cincuenta y nueve mil novecientos noventa y cinco DOLARES AMERICANOS CON 00/100</strong></td>
                </tr>
                <tr>
                <td>En número</td>
                <td colspan="4"><strong>USD 59,995.00</strong></td>
                </tr>
                <tr>
                <td colspan="5" class="textoCentreado">FORMA DE PAGO</td>
                </tr>
                <tr>
                <td colspan="5" class="textoCentreado">1. Abono Inicial a pagarse con Bono Solidario</td>
                </tr>
                <tr>
                <td>En Letra</td>
                <td colspan="4"><strong>DIEZ MIL DOLARES AMERICANOS CON 00/100</strong></td>
                </tr>
                <tr>
                <td>En número</td>
                <td colspan="4"><strong>USD 10,000.00</strong></td>
                </tr>
                <tr>
                <td colspan="5">En cualquier caso que al PROMITENTE COMPRADOR se le niegue el beneficio del Bono
                    Solidario éste asume el compromiso de pago de cualquier saldo que resulte luego de determinar la
                    diferencia entre el Financiamiento aprobado y el precio de la FINCA. Este monto deberá cancelarse
                    en un plazo de seis (6) meses contados a partir de la firma de este contrato o en todo caso deberá
                    estar enteramente pagado para el momento de la firma de la escritura de compraventa de la FINCA.
                </td>
                </tr>
                <tr>
                <td colspan="5"></td>
                </tr>
                <tr>
                <td colspan="5" class="textoCentreado">2. Saldo Insoluto</td>
                </tr>
                <tr>
                <td>En Letra</td>
                <td colspan="4"><strong>cuarenta y nueve mil novecientos noventa y cinco DOLARES AMERICANOS CON 00/100</strong></td>
                </tr>
                <tr>
                <td>En número</td>
                <td colspan="4"><strong>USD 49,995.00</strong></td>
                </tr>
                <tr>
                <td colspan="3">Forma de Pago</td>
                <td colspan="2">Monto</td>
                </tr>
                <tr>
                <td colspan="3">Carta Bancaria</td>
                    <td colspan="2"></td>
                    </tr>
                <tr>
                    <td colspan="5"></td>
                    </tr>
                <tr>
                <td colspan="5">El PROMITENTE COMPRADOR asume el compromiso de pago de cualquier saldo que resulte
                    luego de determinar la diferencia entre el Financiamiento aprobado y el precio de la FINCA. Este
                    monto deberá cancelarse en un plazo de seis (6) meses contados a partir de la firma de este contrato
                    o en todo caso deberá estar enteramente pagado para el momento de la firma de la escritura de
                    compraventa de la FINCA.
                </td>
                </tr>
                <tr>
                <td colspan="5"></td>
                </tr>
                <tr>
                <td>Gastos Legales</td>
                <td><strong>USD 850.00</strong></td>
                <td>Trámites</td>
                <td><strong>USD 350.00</strong></td>
                <td>
                            <strong>Promoción de (USD 1,200.00 crédito)</strong>
                        </td>
                </tr>
                <tr>
                <td colspan="5"><strong>Saldo por pagar de gastos legales es de USD 0.00</strong></td>
                </tr>
            </table>
            <h1></h1>
            <h4 class="">Parte B: Condiciones Particulares</h4>
            <p><strong>Cláusula 1: Consentimiento Informado:</strong> EL PROMITENTE COMPRADOR otorga expresamente su “consentimiento informado” de comprar puesto que ha entendido correctamente las características del proyecto y de la FINCA.</p>
            <p><strong>Cláusula 2: Variaciones Superficiarias:</strong> Acuerdan LAS PARTES que en caso que la superficie total aproximada de LA FINCA aumente por motivos ajenos a las partes, el precio total de venta del mismo, estipulado en la cláusula segunda del presente contrato, variará de acuerdo a dicho aumento a razón del precio de venta por metro cuadrado (M2) acordado en la referida cláusula, la variación en la superficie no podrá aumentar el precio en más de cinco por ciento (5%). Si, por el contrario, ocurriera una disminución en la superficie total aproximada, el precio de venta disminuirá en igual proporción, pero nunca en más de un cinco por ciento (5%). El pago o reembolso según se trate, deberá realizarse antes de que se realice la inscripción de la escritura de compraventa en el Registro Público. </p>
            <p><strong>Cláusula 3: Exclusiones del Precio:</strong> Queda expresamente convenido que el precio de venta no incluye el costo de suministro, ni instalación de las lámparas de LA FINCA, aires acondicionados u otros electrodomésticos, gastos legales o gastos de inscripción, todos los cuales correrán por cuenta de <strong>EL PROMITENTE COMPRADOR</strong>.</p>
            <p><strong>Cláusula 4: No variación de Diseño: EL PROMITENTE VENDEDOR</strong> advierte a <strong>EL PROMITENTE COMPRADOR</strong> que por razón del diseño del Proyecto en el cual se construirá LA FINCA, queda estrictamente prohibido hacer cambios o adiciones a la misma. En caso de requerirse cambios, los mismos deberán contar con la previa autorización del <strong>VENDEDOR</strong>.  Queda expresamente convenido que, durante el periodo de construcción, <strong>EL PROMITENTE COMPRADOR</strong> se obliga a no interferir en la construcción LA FINCA.</p>
            <p><strong>EL PROMITENTE COMPRADOR</strong> acepta que <strong>EL PROMITENTE VENDEDOR</strong> podrá efectuar los cambios que crea convenientes en el anteproyecto, elaborar planos definitivos e introducir cambios a éstos a su discreción, sin que ello requiera del consentimiento o la comunicación previa a <strong>EL PROMITENTE COMPRADOR</strong> siempre y cuando estos no afecten el diseño básico de LA FINCA.</p>
            <p><strong>Cláusula 5: Ubicación de la FINCA: LAS PARTES</strong> acuerdan un plazo para la asignación definitiva de la ubicación de la FINCA dentro del Proyecto, con el ánimo de permitir al <strong>PROMITENTE COMPRADOR</strong> que gestione el financiamiento bancario. En un plazo no mayor de 15 días contados a partir de que el <strong>PROMITENTE COMPRADOR</strong> remita carta de aprobación de financiamiento, <strong>LAS PARTES</strong> determinaran mediante adenda a este contrato la ubicación geográfica definitiva de LA FINCA dentro del Proyecto. En caso que EL BANCO o cualquier ente FINANCIERO requiera (como requisito del trámite de aprobación del financiamiento) una designación, <strong>EL PROMITENTE VENEDEDOR</strong> podrá emitir una proforma o adenda designado una ubicación especifica. Si las partes no se pusieran de acuerdo en cuanto a una ubicación el <strong>PROMITENTE COMPRADOR</strong> podrá declinar la compra y recibir el 100% de las sumas que hubiere pagado en concepto de abono. Esta excepción de cumplimiento es válida únicamente para esta situación puntual.</p>
            <p>PARAGRAFO: Cuando la carta de aprobación de financiamiento se emita de forma condicionada, para los efectos de esta cláusula, se entenderá como no aprobado, y la designación se la FINCA se diferirá hasta que se emita la aprobación de forma definitiva.</p>
            <p><strong>Cláusula 6: Condiciones inherentes al Precio y su forma de pago:</strong></p>
            <p><strong>Carta Bancaria:</strong> Cuando el saldo restante del precio de venta <strong>se garantizará</strong> mediante Carta de Promesa Irrevocable de Pago esta tendrá que ser (cedible) y emitida por un banco de la localidad, aceptado por <strong>EL PROMITENTE VENDEDOR</strong>, que será pagadera al momento de la inscripción en el Registro Público de la Escritura Pública de compraventa definitiva de LA FINCA a favor de <strong>EL PROMITENTE COMPRADOR</strong>.  Dicha carta de promesa de pago irrevocable será entregada en las oficinas de <strong>EL PROMITENTE VENDEDOR</strong> a más tardar 15 (QUINCE) días calendario contados a partir de la firma del presente Contrato de Promesa de Compraventa. EL PROMITENTE COMPRADOR se obliga a mantenerla vigente durante toda la duración de este contrato o hasta que la misma deba ejecutarse.</p>
            <p><strong>Pago sin Carta Promesa (Fondos Propios):</strong> En el supuesto que <strong>EL PROMITENTE COMPRADOR</strong> no pretenda utilizar financiamiento bancario, éste deberá presentar una carta de garantía emitida por una entidad financiera reconocida en la plaza que acredite que tiene a su disposición los fondos necesarios para pagar el saldo del precio. Esta carta de garantía deberá ser entregada al <strong>PROMITENTE VENDEDOR</strong> en un plazo de QUINCE (15) DIAS posteriores a la firma de este contrato. Siempre que exista la exigencia de presentar una carta de garantía bancaria EL PROMITENTE COMPRADOR se obliga a mantenerla vigente durante toda la duración de este contrato o hasta que la misma deba ejecutarse.</p>
            <p><strong>Gastos Legales:</strong> Los gastos legales, administrativos y de manejo, correrán por cuenta de EL PROMITENTE COMPRADOR.</p>
            <p><strong>Bono Solidario:</strong> Cuando EL PROMITENTE COMPRADOR sea beneficiario del programa de Bono Solidario garantizará el pago de dicho Bono mediante carta promesa de pago irrevocable de BANCO NACIONAL DE PANAMÁ, S.A. por la suma de  <strong><u>DIEZ MIL DOLARES CON CERO CERO CENTESIMOS (US$10,000.00)</u></strong> correspondiente al <strong>Programa de Fondo Solidario de Vivienda</strong>, implementado por el <strong>MINISTERIO DE VIVIENDA</strong>, mediante el Articulo Quince (15) del Decreto Ejecutivo diez (10) de quince (15) de enero de dos mil diecinueve (2019), modificado por el Decreto Ejecutivo cincuenta (50) de treinta y uno (31) de mayo de dos mil diecinueve (2019); a entregarse antes de la firma de la escritura de compraventa.</p>
            <p>El PROMITENTE COMPRADOR, cuando se beneficie del programa acepta cumplir con las disposiciones del artículo 15 de la referida norma, el cual establece:</p>
            <p><i>“Articulo Quince (15): El beneficiario del aporte económico de que treta el FSV, con independencia de las restricciones de dominio que se le impongan mediante el contrato de préstamo  con garantía hipotecaria, no podrá transferir la propiedad de LA FINCA adquirida con esta asistencia en el término de cinco (5) años, salvo que se trate de un traspaso por sucesión por causa de muerte, o traspaso a favor de alguno de los miembros del grupo familiar, a saber cónyuge, concubino, concubina, hijos, padres, o restituya previamente el monto total del aporte a EL MIVIOT, o sea el monto total desembolsados en concepto de Bono Solidario tratándose de un tercero. Esta restricción al dominio deberá consignarse en las escrituras públicas que se confeccionen y registrarse en el Registro Público para que proceda el pago, sea al Promotor o a la Institución y financieras que se trate”; para el cual EL (LOS) PROMITENTES(S) COMPRADOR(ES) han aplicado. Para la entrega de esta carta promesa de pago EL (LOS) PROMITENTES(S) COMPRADOR(ES) contarán con un término de sesenta (60) días calendario, contados a partir de la firma del presente contrato.</i></p>
            <p><strong>Incremento del Precio:</strong> LAS PARTES declaran conjuntamente que el precio de venta de LA FINCA ha sido acordado teniendo en cuenta los costos vigentes a la fecha del presente Contrato. Cualquier aumento por creación de nuevos impuestos o el aumento de los existentes u otros factores que incidan en el costo de construcción de LA FINCA durante el período de desarrollo del proyecto, desde la preventa hasta la obtención del permiso de ocupación, ocasionará un aumento del Precio de Venta, sin embargo, estos posibles aumentos en los costos, no podrán aumentar en más del diez por ciento (10%) el Precio de Venta Final de LA FINCA. En caso de que ocurriese dicho aumento, será pagado junto con él último pago que se deba hacer de conformidad con lo acordado en el presente Contrato o en todo caso en un plazo no mayor de treinta (30) días posteriores a la fecha en que se notifique a EL PROMITENTE COMPRADOR la aplicación del aumento a la dirección y por los medios dispuestos en este contrato.</p>
            <p><strong>El incremento se notificará en cualquier momento antes de que se firme la escritura de compraventa definitiva.</strong></p>
            <p>Una vez que se determine la necesidad del cobro, EL PROMITENTE VENDEDOR procederá a efectuar la correspondiente notificación la cual acompañará con prueba suficiente del incremento. Para los efectos, LAS PARTES, acuerdan como prueba suficiente un cuadro en Excel básico refrendado por un contador público autorizado en el que se haga una relación entre los costos iniciales y los actuales según el rubro que hubiese producido el incremento. Se usará una formula simple para demostrar el incremento, por medio de la cual se aumentará al precio original el incremento producido por la incidencia del factor causante del alza resultando así el nuevo precio.</p>
            <p>Según lo que establece el artículo 79 de la Ley 45 de Protección al Consumidor y el artículo 43 del Decreto 46 de 23 de junio de 2009, cualquier verificación que se haga para materiales deberá hacerse aplicando un método de índices y en caso de que no existan, LAS PARTES se someten a lo descrito y regulado en este contrato. EL PROMITENTE COMPRADOR acepta que no se discriminará ninguna causal de aumento siempre que la Ley no disponga otra cosa.</p>
            <p><strong>Intereses Moratorios:</strong> Sin perjuicio de los derechos que tiene el PROMITENTE VENDEDOR de rescindir este contrato por incumplimiento, LAS PARTES acuerdan que en caso de mora en el pago del precio de venta de LA FINCA incluyendo abonos o cualquier saldo pendiente de pago, EL PROMITENTE VENDEDOR tendrá derecho a cobrar un interés por mora de 10% mensual aplicable sobre saldo moroso y por todo el tiempo que la deuda permanezca pendiente de pago.</p>
            <p><strong>Tiempos aplicables para pago:</strong> Cuando exista necesidad de determinar la fecha exacta desde la cual se empieza a contar el plazo en que se debe efectuar un pago, LAS PARTES se remitirán a la fecha de firma de este contrato de promesa sin perjuicios de las prórrogas que resulten aplicables.</p>
            <p><strong>Transferencias Internacionales:</strong> Los cargos y gastos producidos por el uso de esta mecánica de pago serán a cargo y cuenta de <strong>EL PROMITENTE COMPRADOR</strong>.</p>
            <p><strong>Procedencia del Dinero:  EL PROMITENTE COMPRADOR</strong> declara expresamente la procedencia lícita de los fondos que utiliza para esta compra y se responsabiliza frente al PROMITENTE VENDEDOR y frente a terceros de la naturaleza y origen de dichos fondos.</p>
            <p>Para los fines de la Ley 23 de 27 de Abril de 2015 <strong><i>“Que adopta medidas para prevenir el blanqueo de capitales, el financiamiento del terrorismo y el financiamiento de la proliferación de armas de destrucción masiva y dicta otras disposiciones"</i> EL PROMITENTE COMPRADOR</strong> se obliga a suministrar toda y cualquier información que demuestre el origen lícito de los fondos que utiliza, y autoriza a <strong>EL PROMITENTE VENDEDOR</strong> para realizar toda y cualquier diligencia tendiente a determinar la validez de sus aportes e información. <strong>LAS PARTES</strong> acuerdan que es causal especial de terminación de este contrato el incumplimiento de lo dispuesto en esta sección, de modo que <strong>EL PROMITENTE VENDEDOR</strong> podrá, a su discreción, terminar de forma inmediata este contrato sin necesidad de resolución judicial, si considera incumplidas las normas propias de debida diligencia y que en efecto se determine el origen ilícito de los fondos, o en el evento que tal origen no se pueda determinar, sin importar las razones que motiven dicha falencia.</p>
            <p><strong>Gestión de Cobro:  EL PROMITENTE COMPRADOR</strong> está obligado a suministrar una dirección real la cual está dispuesta en este contrato y se obliga a mantenerla actualizada durante todo el tiempo que transcurra entre la firma de este contrato y la fecha efectiva de entrega de su VIVIENDA. LAS PARTES acuerdan que las notificaciones hechas entre ellas deberán hacerse a las direcciones consignadas en este contrato en la sección dispuesta como COMUNICACIONES.  <strong>EL PROMITENTE COMPRADOR</strong> reconoce la validez y efectividad de las notificaciones que se le hagan vía correo electrónico incluyendo los avisos y comunicados relativos a gestión de cobro, aumento de precio, requerimientos de pagos, comunicación de fechas y en general toda comunicación que deba surtir un efecto legal o contractual.</p>
            <p><strong>Cláusula 7: Duración del Contrato y Plazo de Construcción: EL PROMITENTE VENDEDOR</strong> se compromete a construir, sobre el lote a segregarse de la Finca Madre, LA FINCA y entregarla en <strong>un plazo veinticuatro (24) meses contados a partir de la emisión del permiso de construcción definitivo del proyecto.</strong></p>
            <p><strong>EL PROMITENTE VENDEDOR</strong> tendrá derecho a una prórroga de <strong>doce (12) meses</strong> aplicables a su sola discreción y de forma inmediata al vencimiento del plazo principal la cual correrá sin necesidad de notificación o autorización previa.</p>
            <p>LAS PARTES acuerdan que siendo que LA FINCA forma parte de un residencial con áreas comunes, la entrega de LA FINCA no necesariamente coincidirá con la terminación del resto de las áreas del Proyecto.</p>
            <p><strong>EL PROMITENTE VENDEDOR</strong> no será responsable por demoras u atrasos ocasionados por causas que le resulten ajenas, caso fortuito, fuerza mayor u ocurrencia de cualquier evento fuera del control de <strong>EL PROMITENTE VENDEDOR</strong>, entre los que se mencionan si intensión de ser limitativos:</p>
            <ol type="a">
                <li>Que la Empresa de Energía Eléctrica o IDAAN no realizaran oportunamente las conexiones domiciliaras del Proyecto;</li>
                <li>Si el Cuerpo de Bomberos o la Alcaldía/ Ingeniería Municipal no expidieran oportunamente los permisos correspondientes;</li>
                <li>Si el Ministerio de Vivienda demorare la aprobación del Reglamento de Propiedad Horizontal (cuando aplique)</li>
                <li>Por causas de disturbios público, huelga o problemas en la industria de la construcción;</li>
                <li>Por escasez de mano de obra y materiales, demoras del contratista en la construcción del proyecto;</li>
                <li>Creación de nuevos requerimientos, regulaciones o legislación relativa a la construcción y/o la propiedad inmueble u horizontal.</li>
                <li>Cualquier otra causa no imputable a <strong>EL PROMITENTE VENDEDOR</strong> como por ejemplo condiciones climáticas adversas, causa fortuita o de fuerza mayor. </li>
            </ol>
            <p><strong>Cláusula 8: Firma de la Escritura:</strong> LAS PARTES acuerdan que la Escritura de Compraventa por medio de la cual se transferirá la propiedad de LA FINCA objeto del presente contrato a favor de <strong>EL PROMITENTE COMPRADOR</strong>, se otorgará a más tardar en <strong><u>tres (3) días</u></strong> calendario contados a partir de la fecha de expedición del PERMISO DE OCUPACION DEFINITIVO DEL PROYECTO. Para los efectos de este contrato el término “otorgar la escritura” es igual a confeccionar y disponer la escritura para firma de las partes. Dentro del plazo de <strong><u>cinco (5) días</u></strong> contados de forma seguida a los TRES (3) días para el otorgamiento de la escritura, EL PROMITENTE COMPRADOR se compromete a entregar todos los documentos que se le requieran para la inscripción de la escritura, incluyendo aquellos que deba entregar al BANCO FINANCIADOR, -cuando exista financiamiento-, esto, a fin de asegurar el cumplimiento de las formalidades a su cargo, necesarias para inscribir la compraventa y el préstamo hipotecario si fuera el caso.</p>
            <p><strong>Cláusula 9: Penalidad aplicable en caso de demora en el pago final:</strong> Llegada la fecha de la entrega formal de LA FINCA o desde que fuera emitido el permiso de Ocupación de esta (lo que ocurra primero) <strong>EL PROMITENTE COMPRADOR</strong> se obliga a pagar a <strong>EL PROMITENTE VENDEDOR</strong>, una suma mensual equivalente al uno por ciento (1%)  sobre el saldo insoluto  adeudado del precio de venta  de LA FINCA objeto del presente contrato, durante todo el tiempo que dure el impago, ya sea que <strong>EL PROMITENTE COMPRADOR</strong> habite o no LA FINCA, y que se haya instalado o no los servicios de agua, luz y teléfono, hasta un máximo de tres (3) meses.</p>
            <p>El período de tres (3) meses descrito en el párrafo anterior para el pago mensual del uno por ciento (1%) sobre el saldo insoluto adeudado del precio de venta, podrá aumentar si por causas imputables a <strong>EL PROMITENTE COMPRADOR</strong> o su entidad financiera no se ha formalizado la protocolización o inscripción en el Registro Público de la escritura de compraventa, en cuyo caso <strong>EL PROMITENTE COMPRADOR</strong> pagará dicho porcentaje hasta la fecha en que se haya cancelado la totalidad del saldo adeudado. No obstante lo anterior, vencido el plazo indicado anteriormente en los párrafos que preceden, quedan a opción exclusiva de <strong>EL PROMITENTE VENDEDOR</strong>, el recibir las sumas de dinero que aquí se pacta o bien declarar rescindido el presente contrato, en cuyo caso, <strong>EL PROMITENTE VENDEDOR</strong> retendrá en concepto de indemnización, el 90% de las sumas que hasta la fecha le hayan sido abonadas a cuenta de <strong>EL PROMITENTE COMPRADOR</strong>.</p>
            <p><strong>PARAGRAFO: <u>CONDICIÓN DE EQUILIBRIO CONTRACTUAL:</u></strong> Queda convenido que EL PROMITENTE COMPRADOR no será responsable y por tanto se exime de pagar el 1% antes dispuesto si la escritura pública de compraventa definitiva no pudiese otorgarse o inscribirse dentro de los términos aquí convenidos por causas no imputables a él o a su Banco, tales como circunstancias fuera de su control, caso fortuito o fuerza mayor. En estos casos, dicha escritura se otorgará tan pronto hubiese desaparecido las causas que impedían su otorgamiento o inscripción según fuere el caso.</p>
            <p><strong>Cláusula 10: Obligaciones contractuales del PROMITENTE COMPRADOR: EL PROMITENTE COMPRADOR</strong> acepta las siguientes obligaciones:</p>
            <ol type="a">
                <li>Acepta el Reglamento de Copropiedad del PROYECTO, así como acepta cumplir y ajustarse a las obligaciones y restricciones que imponga dicho Reglamento una vez el mismo sea aprobado y se encuentre inscrito en el Registro Público por la vía que EL PROMITENTE VENDEDOR seleccione, esto es inscripción del PROYECTO al régimen de Propiedad Horizontal, inscripción de limitaciones en el contrato de compraventa o conformación de una Asociación de Co Propietarios.</li>
                <li>Entregar oportunamente toda la documentación necesaria para el perfeccionamiento del contrato de compraventa definitivo, de la hipoteca, y cualquier documentación requerida para la inscripción de la escritura respectiva en el Registro Público.</li>
                <li>Aceptar como Administrador del Proyecto o PH a la persona natural o jurídica que designe <strong>EL PROMITENTE VENDEDOR</strong> por los plazos establecidos en el Reglamento de Co Propiedad o por la Junta Directiva de la Propiedad Horizontal. En caso que se opte por crear una Asociación de Co Propietarios <strong>EL PROMITENTE COMPRADOR</strong> se obliga a formar parte de ésta y no renunciar a ella mientras esa sea la figura de administración imperante.</li>
                <li>No instalar unidades de aire acondicionado de ventana o unidades separadas, en lugares distintos a los previstos en los planos, con el fin de no alterar la fachada de LA FINCA.</li>
                <li>Entregar al <strong>PROMITENTE VENDEDOR</strong>, cuando éste lo solicite y una vez Expedido del Permiso de Ocupación, la suma de <strong>CINCUENTA DOLARES CON 00/100 (US$ 50.00)</strong> para formar parte de un fondo inicial de administración del PROYECTO; suma de la cual dispondrá el <strong>PROMITENTE VENDEDOR</strong> o el Administrador designado, con la obligación de rendir cuentas.</li>
                <li>Pagar las cuotas que sean fijadas, según la mecánica de administración seleccionada, para los gastos de administración y mantenimiento de las áreas comunes del PROYECTO a partir de la Fecha del Permiso de Ocupación.</li>
                <li>No alterar la fachada exterior de LA FINCA, al menos que sea aprobada por el <strong>PROMITENTE VENDEDOR</strong>. LAS PARTES acuerdan que no se considerará alteración de la fachada de LA FINCA la colocación de techo sobre los estacionamientos ni la construcción de cercas o muros.  Sin embargo, con relación a toda cerca o muro, <strong>EL PROMITENTE COMPRADOR</strong> se obliga a mantener los retiros que establecen las normativas de construcción con la que están aprobados los planos. Queda entendido que LA FINCA está en un proyecto de casas de un solo nivel o planta, por lo que queda prohibida la construcción o edificación de un segundo nivel o planta en LA FINCA.</li>
                <li>Cualquier morosidad respecto al pago de las cuotas previstas en los literales e y f, causaran un recargo del diez por ciento (10%) mensual.</li>
                <li><strong>EL PROMITENTE COMPRADOR</strong> acepta que todos los asuntos pertinentes a la construcción de LA FINCA serán llevados a cabo por <strong>EL PROMITENTE VENDEDOR</strong> y sus representantes. <strong>EL PROMITENTE COMPRADOR</strong> acuerda no interferir ni interrumpir los trabajos de cualquiera de los trabajadores de <strong>LA FINCA</strong>.  Ninguna inspección personal (adicional a la inspección previa) será permitida.  <strong>EL PROMITENTE COMPRADOR</strong> no podrá ordenar trabajos a <strong>LA FINCA</strong> que no sean opciones o extras pre pagadas que <strong>EL PROMITENTE VENDEDOR</strong> haya aceptado por escrito proporcionar, luego de la firma de la escritura de traspaso de <strong>A FINCA</strong>. <strong>EL PROMITENTE COMPRADOR</strong> reconoce que <strong>EL PROMITENTE VENDEDOR</strong> no está obligado a aceptar proporcionar dichas extras u opciones.</li>
                <li><strong>EL PROMITENTE COMPRADOR</strong> soportará la ejecución de las fases de construcción restantes de EL PROYECTO, así como las reparaciones, conservación, y mantenimiento que resulten necesarias efectuar a las viviendas construidas en EL PROYECTO, y deberán permitir el acceso y paso del equipo, maquinarias necesarias, a los arquitectos, obreros, contratistas y demás personas encargadas de vigilar, dirigir y ejecutar dichas obras. De igual forma permitirá (n) la ejecución de los trabajos de construcción de las otras viviendas que se construyan y/o planeen construir en el perímetro cerrado correspondiente al Proyecto Residencial. EL PROMITENTE VENDEDOR deberá tomar las medidas preventivas necesarias</li>
            </ol>
            <p><strong>Cláusula 11: Obligaciones contractuales del PROMITENTE VENDEDOR: EL PROMITENTE VENDEDOR</strong> acepta las siguientes obligaciones:</p>
            <ol type="a">
                <li>Poner a disposición de <strong>EL PROMITENTE COMPRADOR</strong>, LA FINCA a que se refiere este contrato, para que éste a su arbitrio lo use o no, una vez que se cumplan los siguientes requisitos:</li>
                <ul>
                <li>Que se hayan obtenido los permisos de ocupación de las autoridades correspondientes.</li>
                <li>Que <strong>EL PROMITENTE COMPRADOR</strong> haya cumplido con los pagos y acuerdos establecidos en el presente contrato.</li>
                <li>Que <strong>EL PROMITENTE COMPRADOR</strong> firme a satisfacción el Acta de entrega de LA FINCA.</li>
                <li>Que <strong>EL PROMITENTE COMPRADOR</strong> haya entregado a <strong>EL PROMITENTE VENDEDOR</strong> la Carta Promesa de pago Irrevocable a que hace referencia el presente Contrato.</li>
                <li>Que la escritura de compraventa se encuentre debidamente inscrita en el Registro Público y que el Banco haya realizado el desembolso de la carta promesa de pago irrevocable a <strong>EL PROMITENTE VENDEDOR</strong>.</li>
                </ul>
                <li><strong>EL PROMITENTE VENDEDOR</strong> se compromete a cumplir con los tiempos y plazos estipulados en este contrato, así como a construir y entregar LA FINCA con las especificaciones aquí declaradas.</li>
            </ol>
            <p><strong>Cláusula 12: Entrega:</strong> A <strong>EL PROMITENTE COMPRADOR</strong> se le dará la oportunidad antes de recibir <strong>LA FINCA</strong> - en el día y hora previamente establecido por ambas partes-, de inspeccionar la misma con un representante de <strong>EL PROMITENTE VENDEDOR</strong>.  No obstante, dicha fecha de inspección deberá ser acordada dentro de un plazo no mayor de cinco (5) días calendarios a partir del día en que <strong>EL PROMITENTE VENDEDOR</strong> le comunique a <strong>EL PROMITENTE COMPRADOR</strong> que <strong>LA FINCA</strong> está lista para ser inspeccionada.  El día de la inspección <strong>EL PROMITENTE COMPRADOR</strong> firmará un documento de inspección listando cualquier defecto en mano de obra o materiales en LA FINCA que descubra. Si existieran defectos en mano de obra y/o materiales (teniendo en cuenta los estándares legales de construcción aplicables en la República de Panamá), <strong>EL PROMITENTE VENDEDOR</strong> quedará obligado a corregir los defectos a sus costas dentro de un tiempo razonable posterior a la firma de la escritura de traspaso de <strong>LA FINCA</strong> (que no podrá ser de más de un año), pero la obligación de <strong>EL PROMITENTE VENDEDOR</strong> de corregir no dará el derecho de diferir la firma de la escritura de traspaso de <strong>LA FINCA</strong>,  ni de imponer cualquier condición para su firma, ya que la recepción de ésta no afecta o anula la obligación de reparar en los términos aquí establecidos.</p>
            <p>La fecha de inspección podrá re programarse una sola vez, esto significa expresamente que <strong>EL PROMITENTE COMPRADOR</strong>, una vez fijada una fecha de inspección podrá válidamente no asistir y solicitar hasta por una vez más otra fecha para realizar la inspección.</p>
            <p>Si <strong>EL PROMITENTE COMPRADOR</strong> no aprovecha su derecho de inspeccionar LA FINCA según lo establecido en esta cláusula, <strong>EL PROMITENTE VENDEDOR</strong> no estará obligado a establecer otra inspección antes de la firma de la escritura de traspaso de <strong>LA FINCA</strong> y <strong>EL PROMITENTE COMPRADOR</strong> se considerará que ha aceptado <strong>LA FINCA</strong> en las condiciones en que se encuentra.  No obstante, de lo que se pueda establecer al contrario en este contrato, <strong>EL PROMITENTE COMPRADOR</strong> comprende y acuerda que, al firmar la escritura de traspaso de <strong>LA FINCA</strong>, se considerará que <strong>EL PROMITENTE COMPRADOR</strong> ha aceptado  <strong>LA FINCA</strong> en las condiciones en que se encuentra, exceptuando solo aquellas garantías proporcionadas por la ley (hasta donde sean aplicables) y las obligaciones de reparar de <strong>EL PROMITENTE VENDEDOR</strong> según lo pactado en esta cláusula.</p>
            <p>PARAGRAFO: Desde el momento en que <strong>LA FINCA</strong> es entregada (o se entiende como entregada) quedará ocupada por <strong>EL PROMITENTE COMPRADOR</strong>, por tanto se activan las siguientes obligaciones a su cargo:</p>
            <ol type="a">
                <li>Se inicia el periodo durante el cual se calcula el uno por ciento (1%) sobre saldo de que trata la cláusula QUINTA de este contrato.</li>
                <li>Las siguientes obligaciones se activan como liquidas y exigibles:</li>
                <ul>
                <li><strong>EL PROMITENTE COMPRADOR</strong> asume el pago de todos los gastos, honorarios, y compromisos económicos correspondientes a servicios básicos de electricidad, agua, gas, cable y cualquier otro gasto propio de la habitabilidad de <strong>LA FINCA</strong>.</li>
                <li>Se deberá pagar el monto base para el capital operativo o semilla.</li>
                <li>Cuando el Proyecto sea incorporado al Régimen de Propiedad Horizontal se da inicio a la obligación por parte del <strong>PROMITENTE COMPRADOR</strong> de pagar la cuota de gasto común.</li>
                <li>A partir del momento en que se reciban las llaves de LA FINCA, <strong>EL PROMITENTE COMPRADOR</strong> será el único responsable por cualquier tipo de daño que sufra por actos vandálicos, robos, hurtos, inundaciones o cualesquiera otros producidos por causas no imputables a <strong>EL PROMITENTE VENDEDOR</strong>.</li>
                </ul>
            </ol>
            <p><strong>Cláusula 13: Cesión: EL PROMITENTE VENDEDOR</strong> podrá ceder cualesquiera derechos y obligaciones dimanantes del presente contrato, sin que medie consentimiento de <strong>EL PROMITENTE COMPRADOR</strong>.</p>
            <p><strong>EL PROMITENTE VENDEDOR y EL PROMITENTE COMPRADOR</strong>, convienen y aceptan que <strong>EL PROMITENTE COMPRADOR</strong>, no podrá ceder los deberes, derechos y obligaciones del presente contrato a favor de un tercero, sin el previo consentimiento por parte de <strong>EL PROMITENTE VENDEDOR</strong>. En caso de <strong>EL PROMITENTE VENDEDOR</strong> acepte ésta cesión, la misma estará sujeta al pago por parte de <strong>EL PROMITENTE COMPRADOR</strong>, del cinco por ciento (5%) calculado sobre el precio de venta establecido en el presente contrato, a favor de <strong>EL PROMITENTE VENDEDOR</strong>, para lo cual <strong>EL PROMITENTE COMPRADOR</strong> acepta que para garantizar el pago de dicha comisión, la misma será descontada de los abonos realizados por <strong>EL PROMITENTE COMPRADOR</strong> al precio de venta.</p>
            <p><strong>Cláusula 14: Gastos:</strong> Todos los gastos que ocasione el presente contrato, así como los honorarios de abogados, otorgamiento e inscripción de la escritura de traspaso en el Registro Público, correrán por cuenta de <strong>EL PROMITENTE COMPRADOR</strong>.  Una vez inscrita la Escritura de Traspaso de LA FINCA el trámite de exoneración del impuesto de inmueble de ésta, correrá por cuenta de <strong>EL PROMITENTE COMPRADOR</strong>.</p>
            <p><strong>Cláusula 15: Presencia en proyecto:</strong> Siempre que <strong>EL PROMITENTE VENDEDOR</strong> sea dueño de una o más unidades en el Proyecto, este y sus agentes podrán mantener en el mismo oficinas de construcción, administración o de ventas, y unidad (es) modelo (s).  Los agentes de ventas de <strong>EL PROMITENTE VENDEDOR</strong> podrán mostrar el PROYECTO, y poner letreros de publicidad y hacer todo aquello que sea necesario a opción de <strong>EL PROMITENTE VENDEDOR</strong> para ayudarle a vender o alquilar otras unidades o mejoras a ser construidas en el Proyecto, pero el uso de dichas instalaciones y facilidades por <strong>EL PROMITENTE VENDEDOR</strong> deberán ser razonables, y no podrán interferir de una forma que no sea razonable, con el uso y disfrute del Complejo por los compradores.  Este párrafo continuara en existencia (continuara en efecto) posterior al traspaso de LA FINCA.</p>
            <p><strong>Cláusula 16: Garantías:</strong> Declara <strong>EL PROMITENTE COMPRADOR</strong> que aceptan el límite de responsabilidad del <strong>PROMITENTE VENDEDOR</strong> en concepto de daños por defectos de construcción es de un (1) año solamente contado a partir de la fecha de la expedición del Permiso de Ocupación. No obstante, lo anterior, las fisuras que salgan en los repellos como consecuencia del asentamiento normal de LA FINCA no serán consideradas defectos de construcción. Las garantías de LA FINCA se describen a continuación:</p>
            <p>Elementos individuales contarán con las siguientes garantías:</p>
            <table>
                <tr>
                <td style="width: 45%"></td>
                <td style="width: 30%"></td>
                <td style="width: 25%" colspan="2"><strong>Aplica Restricciones</strong></td>
                </tr>
                <tr>
                <td class="textoCentreado"><strong>Acabado</strong></td>
                <td class="textoCentreado"><strong>Plazo</strong></td>
                <td class="textoCentreado"><strong>SI</strong></td>
                <td class="textoCentreado"><strong>NO</strong></td>
                </tr>
                <tr>
                <td>Pisos / Integridad del Porcelanato</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Pisos / Rotura de piezas</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Pisos / vacío de relleno</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Pisos / juntas</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Pisos / decoloración</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Pisos / nivelación</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Puertas / descuadre</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Puertas / decoloración</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Puertas / rotura</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Puertas / Principal / Descuadre</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Closets / descuadre</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Closets / decoloración</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Mueble de Cocina / descuadre</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Muebles de Cocina / decoloración</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Sobre de cocina /descuadre</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Sobre de cocina / rotura</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Grifería / rotura /mal funcionamiento</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Cerraduras / rotura / mal funcionamiento </td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Cableados / mal estado / mala instalación</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Ductos y desagües / obstrucción</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Ductos y desagües / rotura</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Sobre de cocina / rotura</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Filtraciones</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Vidrios / astillamiento / rotura </td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Marcos de ventas / descuadre</td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
                <tr>
                <td>Paredes / pintura / desprendimiento </td>
                <td class="textoCentreado">1 mes desde entrega</td>
                <td class="textoCentreado">Sí</td>
                <td></td>
                </tr>
            </table>
            <p>Excepciones: EL PROMITENTE VENDEDOR no responderá por daños o desperfectos ocasionados por el uso inadecuado, así como tampoco responderá por el desgate natural o mala instalación o daños producidos por reparaciones y/o instalaciones efectuadas por personas distintas al PROMITENTE VENDEDOR o sus contratistas.</p>
            <p><strong>EL PROMITENTE COMPRADOR</strong> acepta que las siguientes conductas anulan la garantía:</p>
            <ul>
                <li>Mal uso o uso inadecuado</li>
                <li>Intervención o trabajos realizados por personas no idóneas o no autorizadas por la Promotora</li>
                <li>Mala instalación</li>
                <li>Reemplazo (grifería, pintura, puertas, muebles, pisos)</li>
            </ul>
            <p><strong>Cláusula 17: Debida Diligencia:  EL PROMITENTE COMPRADOR</strong> declara que no es objetivo, ni está incluido en ninguna lista restrictiva o vinculante sobre sanciones económicas, lavado de dinero y/o embargos comerciales de los Estados Unidos de América, la Unión Europea, las Naciones Unidas y/o la República de Panamá y no están controlados por, o actúan como agente (s) de, alguno de dichos objetivos sobre Sanciones Comerciales y de Lavado de Dinero.</p>
            <p><strong>Cláusula 18: Incumplimientos:</strong> Convienen LAS PARTES que EL PROMITENTE VENDEDOR podrá declarar resuelto de pleno derecho este Contrato y desistir de celebrar la venta, pudiendo retener a su favor, en concepto de única indemnización, el 90% de las sumas abonadas por <strong>EL PROMITENTE COMPRADOR</strong> al precio de venta, sin que medie ningún tipo de responsabilidad ulterior por parte de EL PROMITENTE VENDEDOR frente a <strong>EL PROMITENTE COMPRADOR</strong> en los siguientes casos:</p>
            <ol type="a">
                <li>Si la Escritura Pública de Compraventa no llega a formalizarse por causas imputables a <strong>EL PROMITENTE COMPRADOR</strong>,</li>
                <li>Si, <strong>EL PROMITENTE COMPRADOR</strong>, comprando con hipoteca, no entregase la carta de promesa de pago irrevocable, no la renovare o no la mantuviera vigente</li>
                <li>Si, <strong>EL PROMITENTE COMPRADOR</strong>, llegase a desmejorar su capacidad de crédito, lo que impida la reactivación del financiamiento y no se pueda llevar a cabo la protocolización y registro de la Escritura Pública,</li>
                <li>Si <strong>EL PROMITENTE COMPRADOR</strong> no entregase los documentos necesarios para la protocolización y registro de la Escritura Pública, o si no firma la Escritura Pública de Compraventa dentro del plazo señalado en el presente contrato,</li>
                <li>En caso de incumplimiento por parte de <strong>EL PROMITENTE COMPRADOR</strong> de cualquiera de los abonos o pagos señalados en el presente Contrato;</li>
                <li>En caso de que <strong>EL PROMITENTE COMPRADOR</strong> se rehúse a pagar la diferencia por aumento en el precio de venta;</li>
                <li>Si <strong>EL PROMITENTE COMPRADOR</strong> incumple con cualquiera de las obligaciones contraídas en el presente Contrato, se entenderá que <strong>EL PROMITENTE COMPRADOR</strong> ha incumplido la obligación de compra y dará derecho a <strong>EL PROMITENTE VENDEDOR</strong> a exigir el cumplimiento de la obligación de que se trate o dar por resuelto este contrato de pleno derecho y sin necesidad de recurrir a los tribunales de justicia, quedando facultado para lo siguiente:</li>
            </ol>
            <p>- Cuando el PROMITENTE COMPRADOR incurra en una o más de la causal de resolución listadas anteriormente EL PROMITENTE VENDEDOR así se lo comunicará a <strong>EL PROMITENTE COMPRADOR</strong> quedando disuelto el contrato de inmediato y <strong>EL PROMITENTE VENDEDOR</strong> podrá ofertar LA FINCA para su venta.</p>
            <p><strong>Cláusula 19: Jurisdicción y Competencia:</strong> Cualquier Litigio o controversia que surja de este contrato así como de su interpretación, aplicación, ejecución y terminación deberá resolverse ante la Justicia Ordinaria de la República de Panamá y en bajo la legislación de este País.</p>
            <p><strong>Cláusula 20: Notificaciones:</strong> Toda notificación que haya que realizarse en este contrato se hará en las siguientes direcciones:</p>
            <p><strong>PROMITENTE COMPRADOR:</strong> Notificaciones a la dirección dispuesta en las condiciones generales del contrato.</p>
            <p><strong>PROMITENTE VENDEDOR:</strong> Notificaciones a la dirección dispuesta en las condiciones generales del contrato.</p>
            <p><strong>Clausula 21: Cumplimiento Imperfecto:</strong> El hecho de que una de las partes permita una o varias veces que la otra incumpla sus obligaciones o las cumpla parcialmente o imperfectamente o en forma distinta a lo pactado o no insista en el cumplimiento de tales obligaciones o no ejerza oportunamente los derechos contractuales o legales que le corresponden, no se reputara a modificación del presente contrato ni obstará en ningún caso para que dicha parte en el futuro insista en el fiel cumplimiento de las obligaciones a cargo de la otra, o ejerza los derechos que le corresponden de conformidad con las leyes y el presente contrato.</p>
            <p><strong>Cláusula 22: Historial de Crédito:</strong> Por este medio, en cumplimiento de la ley 24 de mayo del 2002, <strong>EL PROMITENTE COMPRADOR</strong> autoriza expresamente y de manera irrevocable a <strong>EL PROMITENTE VENDEDOR</strong> sus representantes y/o agentes para solicitar información e investigar mi historial de crédito en todas y cada una de las agencias de información de datos existentes o agentes económicos (incluyendo la <strong>Asociación Panameña de Crédito APC</strong>), en cualquier momento y a su entera discreción sin ser necesaria la autorización expresa del (los) suscrito (s) cada vez que sea necesaria la obtención de dichas referencias. Igualmente autorizo a intercambiar mi (nuestro) historial de crédito con otros agentes económicos. Reconozco que <strong>EL PROMITENTE VENDEDOR</strong> sus representares y/o agentes no serán responsables por errores en los datos existentes ni por los daños y perjuicios que los mismos puedan ocasionar.</p>
            <p><strong>Cláusula 23: Contrato Total:</strong> Este Contrato refleja la totalidad de los acuerdos alcanzados hasta la fecha entre las partes y deja sin efecto todo acuerdo, oral o escrito, de fecha anterior sobre el objeto del mismo.  Las partes podrán, de mutuo acuerdo y por escrito, modificar o complementar el presente Contrato.</p>
            <p><strong>Cláusula 24: Nulidad Subsanable:</strong> Queda entendido y convenido entre LAS PARTES que, si alguna de las estipulaciones del presente Contrato resultare nula según las leyes de la República de Panamá, tal nulidad no invalidará el Contrato en su totalidad, sino que éste se interpretará como si no incluyera la estipulación o estipulaciones que se declaren nulas, y los derechos y obligaciones de las partes contratantes serán interpretadas y observadas en la forma que en derecho proceda.</p>
            <p><strong>Cláusula 25: Timbres:</strong> De acuerdo a lo que dispone el inciso 16 del Artículo 973 del Código Fiscal, no se adhieren timbres a los tres ejemplares de este contrato.</p>
            <p>EN FE DE LO CUAL, las partes suscriben el presente contrato en tres (3) ejemplares del mismo tenor y efecto, en la Ciudad de Panamá, República de Panamá a los <strong>trece</strong> (<strong>13</strong>) días del mes de <strong>octubre</strong> del año (<strong>2022</strong>).</p>
            <table>
                <tr>
                <td style="width: 40%" class="textoCentreado">EL PROMINENTE VENDEDOR</td>
                <td colspan="2" style="width: 60%" class="textoCentreado">EL PROMITENTE COMPRADOR</td>
                </tr>
                <tr>
                <td class="textoCentreado"><strong>Gilma Estela Ho de Herrera</strong></td>
                <td rowspan="3" style="width: 10%">PC 1</td>
                <td style="width: 50%">Nombre: <strong>Marcelino Ruiz</strong></td>
                </tr>
                <tr>
                <td>Ced: <strong>82581002</strong></td>
                <td>Ced: <strong>8453121</strong></td>
                </tr>
                <tr>
                <td rowspan="4">
                    Firma:
                    <br>
                    <div style="text-align: center;">
                                                    <img src="https://completo365.com/img/usO5k5hYsqyxr5pthf2ZKATFofnA9UfT5E7qjTZH.jpeg"  style="height:100px;" >
                                </div>
                </td>
                <td>Firma:
                    <br>
                    <div style="text-align: center;">
                                                            <br><br>
                                                </div>
                </td>
                </tr>
                <tr>
                <td rowspan="3">PC 2</td>
                <td>Nombre:</td>
                </tr>
                <tr>
                <td>Ced:</td>
                </tr>
                <tr>
                <td>Firma:<br><br></td>
                </tr>
            </table>
            </div>

            </body>
        </html>
        EOD;
        $replace = <<<"EOD"
        <td>Firma:<br><div style="text-align: center;"><img id="firma-cliente" src="https://completo365.com/img/usO5k5hYsqyxr5pthf2ZKATFofnA9UfT5E7qjTZH.jpeg"></div></td>
        EOD;

        $result = $helper->replaceHTMLElement($html, $replace);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(14, 10, 14);
        $pdf->SetAutoPageBreak(true, 10);
        $pdf->AddPage();
        $pdf->setFooterCallback(function ($pdf) {
            
        });
        $pdf->writeHTML($result, true, false, true, true, '');
        $pdf->lastPage();
        $pdf->Output(__DIR__ . '/resources/0101011_GP_criptoy13gmail.com.nuevo.pdf', 'F');

        $this->assertFileExists(__DIR__ . '/resources/0101011_GP_criptoy13gmail.com.nuevo.pdf');
    }
}
