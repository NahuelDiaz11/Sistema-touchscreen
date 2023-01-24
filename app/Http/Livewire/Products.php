<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    use WithFileUploads;


    public $name = '', $code = '', $cost = 0, $price = 0, $price2 = 0, $stock = 0, $minstock = 0, $category = 'elegir', $selected_id = 0, $gallery = [];


    public $action = 'Listado', $componentName = 'Catalogo de Productos', $search, $form = false;
    private $pagination = 5;
    protected $paginationTheme = 'tailwind';



    public function render()
    {

        // si el user ingresa algo en la caja de texto buscar significa que esta buscando
        if (strlen($this->search) > 0)
            //relaciones donde se busca por el nombre o por el codigo
            $info = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', "%($this->search)%")
                ->orWhere('products.code', 'like', "%($this->search)%")
                ->orWhere('c.name', 'like', "%($this->search)%")
                ->paginate($this->pagination);

        else
            $info = Product::join('categories as c', 'c.id', 'products.category_id')
                ->select('products.*', 'c.name as category')
                ->paginate($this->pagination);




        return view('livewire.products.component', [
            'products' => $info,
            'categories' => Category::orderBy('name', 'asc')->get()
        ])->layout('layouts.theme.app');
    }

    public $listeners = ['resetUI', 'Destroy'];

    public function noty($msg, $eventName='noty',$reset=true, $action ='')
    {
        $this->dispatchBrowserEvent($eventName, ['msg'=>$msg, 'type'=>'success', 'action'=>$action]);
        if($reset) $this->resetUI();
    }

    //agregar nuevos registros
    public function AddNew()
    {
        $this->resetUI();
        //resetea propiedades y hace una notificacion para que de la part del front se abra una modal
        $this->noty(null, 'open-modal');
    }

    //limpia todos los mensajes en rojo al momento de guardar o actualizar
    //resetea pagina y campos
    public function resetUI()
    {
        $this->resetValidation();
        $this->resetPage();
        $this->reset('name','code','cost','price','price2','stock','minstock','selected_id','search','action','gallery');

    }

    public function CloseModal()
    {
        $this->resetUI();
        $this->noty(null,'close-modal');

    }

    public function Edit(Product $product)
    {
        $this->selected_id=$product->id;
        $this->name=$product->name;
        $this->code=$product->code;
        $this->cost=$product->cost;
        $this->price=$product->price;
        $this->price2=$product->price2;
        $this->stock=$product->stock;
        $this->minstock=$product->minstock;
        $this->category=$product->category_id;
        //se hace una notificacion a travez de noty y le pasamos open modal para que se despliegue el modal y false para que no se reseteen las propiedades
        $this->noty('', 'open-modal',false);
    }



}
