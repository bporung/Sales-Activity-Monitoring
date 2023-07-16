<?php

namespace App\Http\Livewire\Master\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\UserTrait;

class Editpassword extends Component
{
    use UserTrait;

    public $data_id;
    public $username;
    public $result;
    public $state = [];


    public function mount($id){
        $this->data_id = $id;

        $result = 'App\Models\User'::findOrFail($id);
        $this->result = $result;
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
        $role = $this->result->roles()->pluck('id')->first();
        if($role == '3'){
            return view('livewire.master.user.editpassword',[

            ])
            ->layout('layouts.app', [
                'pagetitle' => [
                    ['title' => 'User' , 'link' => '/user'],
                    ['title' => $this->username , 'link' => '/user/'.$this->data_id],
                    ['title' => 'Change Password' , 'link' => ''],
                ], 
            'navigationTab' => [
                ['title' => 'Info' , 'link' => '/user/'.$this->data_id , 'status' => '0'],
                ['title' => 'Edit' , 'link' => '/user/'.$this->data_id.'/edit' , 'status' => '0'],
                ['title' => 'Change password' , 'link' => '/user/'.$this->data_id.'/editpassword' , 'status' => '1'],
                ['title' => 'Edit Sales' , 'link' => '/user/'.$this->data_id.'/editsales' , 'status' => '0'],
                // ['title' => 'Edit subordinate' , 'link' => '/user/'.$this->data_id.'/editsubordinate' , 'status' => '0'],
            ]
            ]);
        }else{
            return view('livewire.master.user.editpassword',[

            ])
            ->layout('layouts.app', [
                'pagetitle' => [
                    ['title' => 'User' , 'link' => '/user'],
                    ['title' => $this->username , 'link' => '/user/'.$this->data_id],
                    ['title' => 'Change Password' , 'link' => ''],
                ], 
            'navigationTab' => [
                ['title' => 'Info' , 'link' => '/user/'.$this->data_id , 'status' => '0'],
                ['title' => 'Edit' , 'link' => '/user/'.$this->data_id.'/edit' , 'status' => '0'],
                ['title' => 'Change password' , 'link' => '/user/'.$this->data_id.'/editpassword' , 'status' => '1'],
                // ['title' => 'Edit Sales' , 'link' => '/user/'.$this->data_id.'/editsales' , 'status' => '0'],
                // ['title' => 'Edit subordinate' , 'link' => '/user/'.$this->data_id.'/editsubordinate' , 'status' => '0'],
            ]
            ]);
            
        }
    }
}
