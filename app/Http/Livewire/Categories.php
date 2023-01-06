<?php

namespace App\Http\Livewire;


use App\Models\Category;
use App\Models\Image;
use GrahamCampbell\ResultType\Success;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Categories extends Component
{

    use WithPagination;
    use WithFileUploads;

    //propiedades publicas
    public $form = false, $name = '', $selected_id = 0, $photo = '';
    public $action = 'Listado', $componentName = 'Categorias', $search = '';
    private $pagination = 4;
    protected $paginationTheme = 'tailwind';


    public function render()
    {
        if (strlen($this->search) > 0)
            $info = Category::where('name', 'like', "%{$this->search}%")->paginate($this->pagination);
        else
            $info = Category::orderBy('name', 'asc')->paginate($this->pagination);


        return view('livewire.categories.component', [
            'categories' => $info
        ])
            ->layout('layouts.theme.app');
    }

    public function Edit(Category $category)
    {
        $this->selected_id = $category->id;
        $this->name = $category->name;
        $this->action = 'Editar';
        $this->form = true;
    }

    public function resetUI()
    {
        //todos los mensajes en rojo que se muestran como error se resetea
        $this->resetValidation();
        //nos vuelve a la pagina principal si eliminamos en otra pagina que no sea la principal
        $this->resetPage();
        //regresa todas las propiedades
        $this->reset('name', 'selected_id', 'search', 'action', 'componentName', 'photo', 'form');
    }
    public function noty($msg, $eventName='noty', $reset = true, $action='')
    {
        $this->dispatchBrowserEvent($eventName,['msg'=>$msg, 'type'=>'success', 'action'=>$action]);
        if($reset) $this->resetUI();
    }

    public function CloseModal()
    {
        $this->resetUI();
        $this->noty(null,'close-modal');
    }

    public function Store()
    {
        //actualizar o crear nuevas categorias
        sleep(1);
        $this->validate(Category::rules($this->selected_id), Category::$messages);


        $category = Category::updatOrCreate([
            ['id' => $this->selected_id],
            ['name' => $this->name]
        ]);

        //si tenemos una nueva imagen se elimina la previa
        if (!empty($this->photo)) {
            //se elimina las imagenes de la carpeta
            $tempImg = $category->imag->file;
            if ($tempImg != null && file_exists('storage/categories/' . $tempImg)) {
                unlink('storage/categoris/', $tempImg);
            }

            //se elimina la relacion con imagenes de la base de datos
            $category->image()->delete();
            //generamos un nombre de archivo unico
            $customFileName = uniqid() . '_.' . $this->photo->extension();
            //guardamos imagen en esta ruta con el nombre unico
            $this->photo->storeAs('public/categories', $customFileName);

            //creamos registro en la bd
            $img = Image::create([
                'model_id' => $category->id,
                'model_type' => 'App\Models\Category',
                'file' => $customFileName

            ]);
            //guardar relacion
            $category->image()->save($img);
        }

        //mandamos feedback
        $this->noty($this->selected_id < 1 ? 'Categoria registrada' : 'Categoria actualizada', 'noty', false, 'close-modal');

        $this->resetUI();
    }

    public function Destroy(Category $category)
    {
        $category->delete();
        $this->noty('Se elimino la categoria');
    }

    //se escuchan los eventros resetui y destroy
    public $listeners = [
        'resetUI','Destroy'
    ];

}
