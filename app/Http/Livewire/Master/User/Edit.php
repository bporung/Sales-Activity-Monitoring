<?php

namespace App\Http\Livewire\Master\User;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\UserTrait;
use Auth;
class Edit extends Component
{
    use UserTrait;

    public $data_id;
    public $username;
    public $user;
    public $result;
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

    public function mount($id){
        $this->data_id = $id;
        $this->roles = $this->getRoles();

        $result = 'App\Models\User'::findOrFail($id);
        $this->result = $result;
        
        $user = Auth::user();
        $this->user = $user;
        $user_id = $user->id;
        if($user->can('edit all user')){

            if(!Auth::user()->hasRole('Super Admin')){
                if($result->hasRole('Super Admin')){
                    abort(403);
                }
            }
            
        }else{
            if($user->can('edit self user')){
                abort(403);
            }
        }

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
            $navTab[] = ['title' => 'Edit' , 'link' => '/user/'.$this->data_id.'/edit' , 'status' => '1'];
            $navTab[] = ['title' => 'Change password' , 'link' => '/user/'.$this->data_id.'/editpassword' , 'status' => '0'];
        }
        if($boolPermissionsTarget && $boolIfSales){
            $navTab[] = ['title' => 'Edit Sales' , 'link' => '/user/'.$this->data_id.'/editsales' , 'status' => '0'];
        }


            return view('livewire.master.user.edit',[

            ])
            ->layout('layouts.app', [
                'pagetitle' => [
                    ['title' => 'User' , 'link' => '/user'],
                    ['title' => $this->username , 'link' => '/user/'.$this->data_id],
                    ['title' => 'Edit' , 'link' => ''],
                ], 
            'navigationTab' => $navTab
            ]);

    }
}
