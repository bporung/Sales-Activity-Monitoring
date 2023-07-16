<?php

namespace App\Http\Livewire\Report\User;

use Livewire\Component;
use Auth;
class Show extends Component
{
    public $data_id;
    public $result;

    public function mount($id){
        $this->data_id = $id;
        $this->result = 'App\Models\User'::findOrFail($id);

    }
    public function render()
    {
        return view('livewire.report.user.show',[

        ])
        ->layout('layouts.app', [
        'pagetitle' => [
            ['title' => 'Report' , 'link' => ''],
            ['title' => 'User' , 'link' => '/report/user'],
            ['title' => $this->result->username , 'link' => '/report/user/'.$this->data_id],
        ] , 
        'navigationTab' => [
            ['title' => 'Info' , 'link' => '/report/user/'.$this->data_id , 'status' => '1'],
        ]
        ]);
    }
}
