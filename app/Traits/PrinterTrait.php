<?php

namespace App\Traits;

use App\Models\Branch;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Setting;
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
    public function PrintTicket($orderId)
    {
        $settings = Setting::first();

        if (!$settings)
            return; // si no hay settings cancelamos la impresión

        // "EPSON-T20III";
        $connector = new WindowsPrintConnector($settings->printer);
        $printer = new Printer($connector);


        /* Nombre de la tienda */
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $logo = EscposImage::load($settings->logo);
        $printer->graphics($logo);

        $printer->setTextSize(3, 3);
        $printer->text("$settings->name \n");
        $printer->selectPrintMode();
        $printer->text("$settings->address \n");
        $printer->text("$settings->phone \n\n");
        $printer->feed();


        /* Titulo del recibo */
        //lo imprime en negrita
        $printer->setEmphasis(true);
        $printer->text("Comprobante de Pago\n\n");
        $printer->setEmphasis(false);

        // headers
        $order = Order::find($orderId);
        //se alinea a la izquierda
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Folio: # $order->id \n");
        $printer->text("Fecha: " . Carbon::parse($order->created_at)->format('d/m/Y h:m:s') . "\n");
        $printer->text("Cliente: " . $order->customer->name . "\n");



        /* Informacion del recibo */
        $items = array();
        foreach ($order->details as $detail) {
            array_push($items, new item($detail->product->name . ' x' . $detail->quantity, $detail->price));
        }

        $itemsQty = new item('Articulos', $order->items);
        $cash = new item('Efectivo', $order->cash, true);
        $total = new item('Total', $order->total, true);
        $change = new item('Cambio', number_format(($order->cash - $order->total), 2), true);



        /* Descripcion importe */
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("===============================================\n");
        $printer->setEmphasis(true);
        $concepts = new item('DESCRIPCION', 'IMPORTE', false);
        $printer->text($concepts->getAsString());
        $printer->setEmphasis(false);
        $printer->text("===============================================\n");
        foreach ($items as $item) {
            $printer->text($item->getAsString()); // for 58mm Font A / 32
        }
        $printer->text("-----------------------------------------------\n");
        $printer->text("\n");

        /* change */
        $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer->text($itemsQty->getAsString());
        $printer->feed();


        /* Efectivo y total */
        $printer->text($cash->getAsString());
        $printer->setEmphasis(true);
        $printer->text($total->getAsString());
        $printer->setEmphasis(false);
        $printer->feed();

        /* change */
        $printer->text($change->getAsString());
        $printer->selectPrintMode();
        $printer->feed();


        /* Footer */

        $printer->feed(2);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("$settings->leyend \n");
        $printer->text("Gracias por su compra\n");
        $printer->feed(2);



        // Codigo de barras
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $folio = str_pad($order->id, 7, "0", STR_PAD_LEFT); //rellena con 5 ceros a la izquierda
        $printer->setBarcodeHeight(60); //altura del barcode
        $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);
        $printer->barcode($folio, Printer::BARCODE_CODE39); //especificamos el formato code39 (7 digitos)
        $printer->feed(2); // generamos 2 espacios/saltos de linea en papel 


        $printer->cut();
        $printer->close();
    }

}

class item
{

    // propiedades
    private $name;
    private $price;
    private $dollarSign;

    // constructor
    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this->name = $name;
        $this->price = $price;
        $this->dollarSign = $dollarSign;
    }

    //Genera un texto con el cual se puede imprimir el nombre del producto ordenando la descripcion al lado izquierdo y el importe a lado derecho del texto
    public function getAsString() 
    {
        // string str_pad($string, $length, $pad_string, $pad_type)

        $rightCols = 10; 
        $leftCols  = 36;
        
        if ($this->dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);
        

        $sign = ($this->dollarSign ? '$ ' : '');
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        

        return "$left$right\n";
    }


    // metodo mágico / todos deben declararse como publicos
    public function __toString()
    {
        //convierte en cadena de texto lo que nos retorne getasstring
        return $this->getAsString();
    }

}