<?php

namespace App\Traits;

use App\Models\Branch;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Customer;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\Models\Config;
use Mike42\Escpos\CapabilityProfile;

trait PrinterTrait
{

    // recibo con logo
    public function PrintTicketTest()
    {
        $nombreImpresora = "EPSON-T20III";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);

        //dd(dirname(public_path()));
        //alinea de forma centrada el ticket
        $impresora->setJustification(Printer::JUSTIFY_CENTER);     
        //imprime logo  
        $logo = EscposImage::load("logoo.png");
        $impresora->bitImage($logo); //$printer -> graphics($logo);

        $impresora->text("\n");
        $impresora->setTextSize(3, 3);
        $impresora->text("FastFOOD\n");
        $impresora->setTextSize(2, 2);
        $impresora->text("Comida Express\n\n");

        $impresora->text("FastFOOD\n");


        $impresora->feed(3);
        $impresora->cut();
        $impresora->close();

      
    }



}
