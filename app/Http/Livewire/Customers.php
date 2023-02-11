<?php

namespace App\Http\Livewire;

use App\Models\User;
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
        ->orWhere('phone', 'like', "%{$this->search}%")
        ->orWhere('street', 'like' ,"%{$this->search}%")
        ->orWhere('number', 'like' ,"%{$this->search}%")
        ->orWhere('city', 'like' ,"%{$this->search}%")
        ->orWhere('province', 'like' ,"%{$this->search}%")
        ->orWhere('zipcode', 'like' ,"%{$this->search}%")
        ->orWhere('country', 'like' ,"%{$this->search}%")
        ->orWhere('notes', 'like' ,"%{$this->search}%")
        ->orderBy('name','asc')
        ->paginate($this->pagination);
        else
        $customers=Customer::orderBy('name','asc')
        ->paginate($this->pagination);

        return view('livewire.customers.component',[
            'customers' => $customers
        ])->layout('layouts.theme.app');
    }

    public function noty($msg, $eventName = 'noty', $reset = true, $action = '')
    {
        $this->dispatchBrowserEvent($eventName, ['msg' => $msg, 'type' => 'success', 'action' => $action]);
        if ($reset) $this->resetUI();
    }

    //inicializa un nuevo registro en bd
    //se llama cuando creamos nuevo registro
    public function AddNew()
    {
        $this->resetUI();
        $this->form = true;
        $this->action='Agregar';
    }

    public function CloseModal()
    {
        $this->resetUI();
        $this->noty(null,'close-modal');

    }


    public function resetUI()
    {
        //resetea validaciones
        $this->resetValidation();
        //resetea el paginado para que se regrese a la pagina pricipal
        $this->resetPage();
        //resetea propiedades como las teniamos declaradas
        $this->reset('name', 'selected_id', 'search',  'componentName', 'phone', 'street', 'number', 'province', 'city', 'zipcode', 'country', 'notes', 'form');
    }

    public function Edit(Customer $customer)
    {
        $this->selected_id = $customer->id;
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->street = $customer->street;
        $this->number = $customer->number;
        $this->province = $customer->province;
        $this->city = $customer->city;
        $this->zipcode = $customer->zipcode;
        $this->country = $customer->country;
        $this->notes = $customer->notes;
        //la propiedad form queda en true para que nos muestre el formulario
        $this->form = true;
    }

    //escuchamos los eventos
    public $listeners=['resetUI','Destroy'];

    public function Store()
    {
        $this->validate(Customer::rules($this->selected_id), Customer::$messages);



        Customer::updateOrCreate(
            ['id'=> $this->selected_id],
            [
                'name' => $this->name,
                'phone' => $this->phone,
                'street' => $this->street,
                'number' => $this->number,
                'province' => $this->province,
                'city' => $this->city,
                'zipcode' => $this->zipcode,
                'country' => $this->country,
                'notes' => $this->notes
            ]

            );
            $this->noty($this->selected_id > 0 ? 'Cliente Actualizado' : 'Cliente Registrado','noty', false, 'close-modal');
            $this->resetUI();

    }

    public function Destroy(Customer $customer)
    {

        //$orders = $customer->orders->count();
        if ($customer->orders->count() < 1) {
            $customer->delete();
            $this->noty("El cliente <b>$customer->name</b> fué eliminado del sistema");
        } else {
            $this->noty("No es posible eliminar el cliente debido a que tiene compras registradas");
        }
    }

}
