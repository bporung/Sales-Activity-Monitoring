<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\UserTrait;
use Auth;

class Show extends Component
{
    use UserTrait;

    public $data_id;
    public $username;
    public $result;


    public function mount(){
        $this->data_id = Auth::user()->id;
        $result = 'App\Models\User'::findOrFail($this->data_id);
        $this->result = $result;
        $this->username = $result->username;
    }

    

    public function render()
    {
        return view('livewire.profile.show',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => $this->username , 'link' => '/profile/'.$this->data_id],
            ], 
        'navigationTab' => [
            ['title' => 'Info' , 'link' => '/profile' , 'status' => '1'],
            ['title' => 'Edit' , 'link' => '/profile/edit' , 'status' => '0'],
            ['title' => 'Change password' , 'link' => '/profile/editpassword' , 'status' => '0'],
        ]
        ]);
    }
}
