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
}
