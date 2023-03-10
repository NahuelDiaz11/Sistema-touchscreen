<?php

namespace App\Http\Livewire;


use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Traits\PrinterTrait;

class Reports extends Component
{
    use PrinterTrait;
    use WithPagination;

    public $search, $startDate, $endDate, $userId = 'TODOS', $details =[];
    private $pagination = 6;

   
    public function render()
    {
        return view('livewire.reports.component', [
            'orders' => $this->getReport(),
            'users' => $this->loadUsers()
        ])->layout('layouts.theme.app');
    }

    public function loadUsers()
    {
        if(strlen($this->search) > 0)
            $users = User::where('name','like',"%{$this->search}%")
                           ->orderBy('name', 'asc')
                           ->get()->take(5);
        else
            $users = User::orderBy('name', 'asc')->get()->take(5);

        return $users;
    }


    public function getReport()
    {
        if ($this->startDate == '' || $this->endDate == '') {
            //rango de consultas
            $from = Carbon::now()->format('Y-m-d');
            $to = Carbon::now()->format('Y-m-d');
        } else {
            $from = Carbon::parse($this->startDate)->format('Y-m-d') . ' 00:00:00';
            $to   = Carbon::parse($this->endDate)->format('Y-m-d') . ' 23:59:59';
        }


        if ($this->userId != 'TODOS'){

            
            $uid = trim(explode("|", $this->userId)[1]);           
             //consulta entre 2 fechas
            $orders = Order::whereBetween('created_at', [$from, $to])
            ->where('user_id', $uid)
            ->orderBy('id', 'desc')
            ->paginate($this->pagination);
        }
        else{
           
            $orders = Order::whereBetween('created_at', [$from, $to])
            ->orderBy('id', 'desc')
            ->paginate($this->pagination);
        }


        return $orders;
    }


    public function viewDetails(Order $order)
    {
        $this->details = $order->details;
        $this->dispatchBrowserEvent('open-modal-detail');
    }


    public function updatedUserId()
    {
        $this->search ='';
        $this->dispatchBrowserEvent('close-modal-user');
    }


    public function rePrint($orderId)
    {
        $this->PrintTicket($orderId);
        $this->dispatchBrowserEvent('noty',['msg' => 'Se envi?? a reimprimir el ticket de Venta','type' => 'success']);
    }
    
    
}
