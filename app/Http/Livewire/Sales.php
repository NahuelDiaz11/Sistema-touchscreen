<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Sales extends Component
{
    
    public $orderDetails = [], $search, $cash, $searchcustomer, $currentStatusOrder, $order_selected_id, $customer_id = null, $changes, $customerSelected = 'Seleccionar Cliente';
    
    // mostrar y activar panels
    public $showListProducts = false, $tabProducts = true, $tabCategories = false;

    // colecctions
    public $productsList = [], $customers = [];
    
    // info carrito
    public  $totalCart = 0, $itemsCart = 0, $contentCart = [];
    
    // producto seleccionado
    public $productIdSelected, $productChangesSelected, $productNameSelected, $changesProduct;

    // pagination style
     protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.sales.component')->layout('layouts.theme.app');
    }
}
