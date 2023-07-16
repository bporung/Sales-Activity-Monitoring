<?php

namespace App\Http\Livewire\Master\Customer;

use Livewire\Component;
use App\Http\Traits\CustomerTrait;

class Show extends Component
{
    use CustomerTrait;
    public $data_id;
    public $result;

    public $interactions;
    public $coordinate;
    
    public function mount($id){
        $result = 'App\Models\Customer'::findOrFail($id);
        $this->data_id = $id;
        $this->result = $result;
        $this->coordinate = $result->latitude.'/'.$result->longitude;

        $this->preparationDatas();
    }
    public function preparationDatas(){
        $results = 'App\Models\Interaction'::orderBy('created_at','DESC')->where('customer_id',$this->data_id)->paginate(10);
        $this->interactions = $results->items();
    }
    public function render()
    {
        return view('livewire.master.customer.show')->layout('layouts.app', [
        'pagetitle' =>  [
            ['title' => 'Customer' , 'link' => '/customer'],
            ['title' => $this->data_id , 'link' => ''],
        ] ,
        'navigationTab' => [
            ['title' => 'Info' , 'link' => '' , 'status' => '1'],
            ['title' => 'Edit ' , 'link' => '/customer/'.$this->data_id.'/edit' , 'status' => '0'],
        ]
        ]);
    }
}
