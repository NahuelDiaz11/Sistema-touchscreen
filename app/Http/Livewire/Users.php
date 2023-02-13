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
}
