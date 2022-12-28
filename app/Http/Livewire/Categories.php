<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Categories extends Component
{
    //propiedades publicas
    public $form = false, $name='', $selected_id=0, $photo='';
    public $action = 'Listado', $componentName= 'Categorias', $search='';
    private $pagination = 4;
    protected $paginationTheme='tailwind';


    public function render()
    {
        return view('livewire.categories.component', [
            'categories'=>[] //retorno categorias a un array vacio
        ])->layout('layouts.theme.app');
    }
}
