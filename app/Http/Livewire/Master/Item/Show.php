<?php

namespace App\Http\Livewire\Master\Item;

use Livewire\Component;
use App\Http\Traits\UserTrait;
use Auth;
class Show extends Component
{
    use UserTrait;

    public $data_id;
    public $result;


    public function mount($id){
        $this->data_id = $id;
        $result = 'App\Models\Item'::findOrFail($id);
        $this->result = $result;
    }

    

    public function render()
    {
       
        $boolPermissionsCreate = Auth::user()->can('edit all item');
        $navTab = [
            ['title' => 'Info' , 'link' => '/item/'.$this->data_id , 'status' => '1'],
        ];
        if($boolPermissionsCreate){
            $navTab[] = ['title' => 'Edit' , 'link' => '/item/'.$this->data_id.'/edit' , 'status' => '0'];
        }

        return view('livewire.master.item.show',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Item' , 'link' => '/item'],
                ['title' => $this->result->name , 'link' => ''],
            ],
        'navigationTab' => $navTab
        ]);
    }
}
