<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;


class Users extends Component
{
    use WithPagination;

    public $name='',$email='',$password='',$temporalpass='', $selected_id=0,$search='',$componentName='USUARIOS',$profile='Admin',$form=false,$action='Listado';

    protected $paginationTheme='tailwind';
    private $pagination=5;

    public function render()
    {
        if(strlen($this->search)>0)
        $users=User::where('name', 'like',"%{$this->search}%")
        ->orWhere('name', 'like',"%{$this->search}%")
        ->orderBy('name','asc')
        ->paginate($this->pagination);
        else
        $users=User::orderBy('name','asc')
        ->paginate($this->pagination);

        return view('livewire.users.component',[
            'users' => $users
        ])
        ->layout('layouts.theme.app');
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
        $this->resetValidation();
        $this->resetPage();
        $this->reset('name','selected_id','temporalpass','search','componentName','email','password','profile','form');
    }

    public function Edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->profile = $user->profile;
        $this->password = null;
        $this->temporalpass = $user->password;
        $this->profile = $user->profile;
        $this->form = true;
        $this->action = 'Editar';
    }

    public $listeners = ['resetUI', 'Destroy'];

    public function Store()
    {
        $this->validate(User::rules($this->selected_id),User::$messages);
        User::updateOrCreate(

            ['id' => $this->selected_id],
            [
                'name' => $this->name,
                'email' => $this->email,
                'profile' => $this->profile,
                //si el usuario ingreso una nueva contraseña se encripta y si no se guarda la que tiene en la bd
                'password' => strlen($this->password) > 0 ? bcrypt($this->password) : $this->temporalpass
            ]
            );

            $this->noty($this->selected_id > 0 ? 'Usuario actualizado' : 'Usuario registrado');
            $this->resetUI();
    }

    public function Destroy(User $user)
    {
        //se pueden eliminan los que no tienen ventas
        if ($user->sales->count() < 1) {
            $user->delete();
            $this->noty("El usuario <b>$user->name</b> fue eliminado del sistema");
        } else {
            $this->noty('No es posible eliminar el usuario porque tiene ventas asociadas');
        }
    }
}
