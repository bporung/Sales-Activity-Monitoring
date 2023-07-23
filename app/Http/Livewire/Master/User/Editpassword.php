<?php

namespace App\Http\Livewire\Master\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\UserTrait;
use Auth;

class Editpassword extends Component
{
    use UserTrait;

    public $data_id;
    public $username;
    public $result;
    public $user;
    public $state = [];


    public function mount($id){
        $this->data_id = $id;

        $result = 'App\Models\User'::findOrFail($id);
        $this->user = Auth::user();
        if(!Auth::user()->hasRole('Super Admin')){
            if($result->hasRole('Super Admin')){
                abort(403);
            }
        }
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

        $boolPermissionsTarget = $this->user->canany(['edit sales target']);
        $boolPermissionsChangePW = $this->user->canany(['edit all user']);
        $boolIfSales = $this->result->hasRole('Sales');
        $navTab = [
                ['title' => 'Info' , 'link' => '/user/'.$this->data_id , 'status' => '0'],
        ];
        if($boolPermissionsChangePW){
            $navTab[] = ['title' => 'Edit' , 'link' => '/user/'.$this->data_id.'/edit' , 'status' => '0'];
            $navTab[] = ['title' => 'Change password' , 'link' => '/user/'.$this->data_id.'/editpassword' , 'status' => '1'];
        }
        if($boolPermissionsTarget && $boolIfSales){
            $navTab[] = ['title' => 'Edit Sales' , 'link' => '/user/'.$this->data_id.'/editsales' , 'status' => '0'];
        }

            return view('livewire.master.user.editpassword',[

            ])
            ->layout('layouts.app', [
                'pagetitle' => [
                    ['title' => 'User' , 'link' => '/user'],
                    ['title' => $this->username , 'link' => '/user/'.$this->data_id],
                    ['title' => 'Change Password' , 'link' => ''],
                ], 
            'navigationTab' => $navTab
            ]);
            
    }
}
