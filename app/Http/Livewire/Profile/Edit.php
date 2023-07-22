<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\UserTrait;
use Auth;
class Edit extends Component
{
    use UserTrait;

    public $data_id;
    public $username;
    public $state = [];

    
    public $roles;
    
    public function getRoles(){
        $rows = 'App\Models\MsRole'::orderBy('name','ASC');
        return $rows->get()->toArray();
    }

    public function mount(){
        $this->data_id = Auth::user()->id;
        $this->roles = $this->getRoles();

        $result = 'App\Models\User'::findOrFail($this->data_id);
        $this->fill(['state' => $result->toArray()]);
        $this->username = $result->username;

        $this->state['role_id'] = $result->roles()->pluck('id')->first();

    }

    public function submit()
    {
        $validatedData = Validator::make(
            $this->state,
            [
                'name' => 'required',
                'email' => 'required|email',
                'username' => 'required',
                'role_id' => 'required',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'email' => ':attribute bukan email valid',
            ],
            [
                'name' => 'Name',
                'email' => 'Email',
                'username' => 'Username',
                'role_id' => 'Role',
            ],
        )->validate();
        $res = $this->editUser($this->state)->getData();
        if($res && $res->status === 200){
            session()->flash('success', 'Your Profile Has Been Updated.');
            return redirect()->to('/profile');
        }else{
            session()->flash('error','There is some error occured');
            return redirect()->to('/profile');
        }
        
    }

    public function render()
    {
        return view('livewire.profile.edit',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => $this->username , 'link' => '/profile'],
                ['title' => 'Edit' , 'link' => ''],
            ], 
        'navigationTab' => [
            ['title' => 'Info' , 'link' => '/profile' , 'status' => '0'],
            ['title' => 'Edit' , 'link' => '/profile/edit' , 'status' => '1'],
            ['title' => 'Change password' , 'link' => '/profile/editpassword' , 'status' => '0'],
        ]
        ]);
    }
}
