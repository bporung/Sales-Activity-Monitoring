<?php

namespace App\Http\Livewire\Master\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\UserTrait;
use Auth;
class Editsales extends Component
{
    use UserTrait;

    public $data_id;
    public $username;
    public $state = [];

    
    

    public function mount($id){
        $this->data_id = $id;

        $result = 'App\Models\User'::findOrFail($id);
        
        $user = Auth::user();
        $user_id = $user->id;
        if($user->can('edit all user')){
            
        }else{
            if($user->can('edit self user')){
                abort(404);
            }
        }

        $this->fill(['state' => $result->toArray()]);
        $this->username = $result->username;

        $this->state['role_id'] = $result->roles()->pluck('id')->first();

        if($this->state['role_id'] != '3'){
            abort(404);
        }

    }

    public function submit()
    {
        $validatedData = Validator::make(
            $this->state,
            [
                'sales_target' => 'required_if:role_id,3|numeric',
                'customer_target' => 'required_if:role_id,3|numeric',
                'interaction_target' => 'required_if:role_id,3|numeric',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'numeric' => ':attribute harus angka',
            ],
            [
                'sales_target' => 'Sales Target',
                'customer_target' => 'Customer Target',
                'interaction_target' => 'Interaction Target',
            ],
        )->validate();
        $res = $this->editSales($this->state)->getData();
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
        return view('livewire.master.user.editsales',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'User' , 'link' => '/user'],
                ['title' => $this->username , 'link' => '/user/'.$this->data_id],
                ['title' => 'Edit Sales' , 'link' => ''],
            ], 
        'navigationTab' => [
            ['title' => 'Info' , 'link' => '/user/'.$this->data_id , 'status' => '0'],
            ['title' => 'Edit' , 'link' => '/user/'.$this->data_id.'/edit' , 'status' => '0'],
            ['title' => 'Change password' , 'link' => '/user/'.$this->data_id.'/editpassword' , 'status' => '0'],
            ['title' => 'Edit Sales' , 'link' => '/user/'.$this->data_id.'/editsales' , 'status' => '1'],
        ]
        ]);
    }
}
