<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\UserTrait;
use Auth;
class Changepassword extends Component
{
    use UserTrait;

    public $data_id;
    public $username;
    public $state = [];


    public function mount(){
        $this->data_id = Auth::user()->id;

        $result = 'App\Models\User'::findOrFail($this->data_id);
        $this->fill(['state' => $result->toArray()]);
        $this->username = $result->username;


    }

    public function submit()
    {
        $validatedData = Validator::make(
            $this->state,
            [
                'password' => 'required|confirmed|min:6',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'confirmed' => ':attribute tidak sama',
            ],
            [
                'password' => 'Password',
            ],
        )->validate();
        $res = $this->editPasswordUser($this->state)->getData();
        if($res && $res->status === 200){
            session()->flash('success', $res->message);
            if($res->redirect_link){
                return redirect()->to($res->redirect_link);
            }
        }else{
            session()->flash('error','There is some error occured');
            if($res->redirect_link){
                return redirect()->to($res->redirect_link);
            }
        }
        
    }

    public function render()
    {
        return view('livewire.profile.changepassword',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => $this->username , 'link' => '/profile'],
                ['title' => 'Change Password' , 'link' => ''],
            ], 
        'navigationTab' => [
            ['title' => 'Info' , 'link' => '/profile' , 'status' => '0'],
            ['title' => 'Edit' , 'link' => '/profile/edit' , 'status' => '0'],
            ['title' => 'Change password' , 'link' => '/profile/editpassword' , 'status' => '1'],
        ]
        ]);
    }
}
