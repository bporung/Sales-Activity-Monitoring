<?php

namespace App\Http\Livewire\Master\User;

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


    public function mount($id){
        $this->data_id = $id;
        $result = 'App\Models\User'::findOrFail($id);
        
        $user = Auth::user();
        $user_id = $user->id;
        if($user->can('read all user')){
            
        }else{
            if($user->can('read self user')){
                    $userArr = [];
                    if(count($user->usersubordinates) > 0){
                        $userArr = $user->usersubordinates->pluck('subordinate_id')->toArray();
                    }
                    array_push($userArr,$user->id);
                    if(!in_array($result->id, $userArr)){
                        abort(404);

                    }
                    
            }else{
                abort(404);
            }
        }

        $this->result = $result;
        $this->username = $result->username;
    }

    

    public function render()
    {

        $role = $this->result->roles()->pluck('id')->first();
        if($role == '3'){
            return view('livewire.master.user.show',[

            ])
            ->layout('layouts.app', [
                'pagetitle' => [
                    ['title' => 'User' , 'link' => '/user'],
                    ['title' => $this->username , 'link' => ''],
                ],
            'navigationTab' => [
                ['title' => 'Info' , 'link' => '/user/'.$this->data_id , 'status' => '1'],
                ['title' => 'Edit' , 'link' => '/user/'.$this->data_id.'/edit' , 'status' => '0'],
                ['title' => 'Change password' , 'link' => '/user/'.$this->data_id.'/editpassword' , 'status' => '0'],
                ['title' => 'Edit Sales' , 'link' => '/user/'.$this->data_id.'/editsales' , 'status' => '0'],
                // ['title' => 'Edit subordinate' , 'link' => '/user/'.$this->data_id.'/editsubordinate' , 'status' => '0'],
            ]
            ]);
        }else{
            return view('livewire.master.user.show',[

            ])
            ->layout('layouts.app', [
                'pagetitle' => [
                    ['title' => 'User' , 'link' => '/user'],
                    ['title' => $this->username , 'link' => ''],
                ],
            'navigationTab' => [
                ['title' => 'Info' , 'link' => '/user/'.$this->data_id , 'status' => '1'],
                ['title' => 'Edit' , 'link' => '/user/'.$this->data_id.'/edit' , 'status' => '0'],
                ['title' => 'Change password' , 'link' => '/user/'.$this->data_id.'/editpassword' , 'status' => '0'],
                // ['title' => 'Edit Sales' , 'link' => '/user/'.$this->data_id.'/editsales' , 'status' => '0'],
                // ['title' => 'Edit subordinate' , 'link' => '/user/'.$this->data_id.'/editsubordinate' , 'status' => '0'],
            ]
            ]);

        }
    }
}
