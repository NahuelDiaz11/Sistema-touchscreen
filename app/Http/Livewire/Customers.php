<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;

    public $name='',$phone='',$street='',$number='',$province='',$city='',$zipcode='',$country='Argentina',$notes='',$selected_id=0;
    public $search='',$componentName='CLIENTES',$action='Listado',$form=false;
    private $pagination=5;
    protected $paginationTheme='tailwind';
    public function render()
    {
        if(strlen($this->search)>0)
        $customers=Customer::where('name','like',"%{$this->search}%")
        ->orWhere('phone','like',"%{$this->search}%")
        ->orWhere('street','like',"%{$this->search}%")
        ->orWhere('number','like',"%{$this->search}%")
        ->orWhere('city','like',"%{$this->search}%")
        ->orWhere('province','like',"%{$this->search}%")
        ->orWhere('zipcode','like',"%{$this->search}%")
        ->orWhere('country','like',"%{$this->search}%")
        ->orWhere('notes','like',"%{$this->search}%")
        ->orderBy('name','asc')
        ->paginate($this->pagination);
        else
        $customers=Customer::orderBy('name','asc')
        ->paginate($this->pagination);

        return view('livewire.customers.component',[
            'customers' => $customers
        ])->layout('layouts.theme.app');
    }
}
