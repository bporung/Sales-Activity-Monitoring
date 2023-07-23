<?php

namespace App\Http\Livewire\Master\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\UserTrait;
use Auth;
class Create extends Component
{
    use UserTrait;

    public $state = [];

    
    public $roles;
    
    public function getRoles(){
        if(Auth::user()->hasRole('Super Admin')){
            $rows = 'App\Models\MsRole'::orderBy('name','ASC');

        }else{
            $rows = 'App\Models\MsRole'::where('name','!=','Super Admin')->orderBy('name','ASC');

        }
        return $rows->get()->toArray();
    }

    public function mount(){
        $this->roles = $this->getRoles();


    }

    public function submit()
    {

        $validatedData = Validator::make(
            $this->state,
            [
                'name' => 'required',
                'email' => 'required|email',
                'username' => 'required',
                'password' => 'required',
                'role_id' => 'required',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'email' => ':attribute bukan email valid',
            ],
            [
                'name' => 'Name',
                'email' => 'Email',
                'password' => 'Password',
                'username' => 'Username',
                'role_id' => 'Role',
            ],
        )->validate();
        $res = $this->createUser($this->state)->getData();
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
        return view('livewire.master.user.create',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'User' , 'link' => '/user'],
                ['title' => 'Create' , 'link' => ''],
            ],
        'navigationTab' => [
            ['title' => 'all' , 'link' => '/user' , 'status' => '0'],
            ['title' => 'create' , 'link' => '/user/create' , 'status' => '1'],
        ]
        ]);
    }
}
