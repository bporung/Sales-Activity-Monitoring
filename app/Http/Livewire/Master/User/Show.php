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
    public $user;


    public function mount($id){
        $this->data_id = $id;
        $result = 'App\Models\User'::findOrFail($id);
        
        $user = Auth::user();
        $this->user = Auth::user();
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

        $boolPermissionsTarget = $this->user->canany(['edit sales target']);
        $boolPermissionsChangePW = $this->user->canany(['edit all user']);
        $boolIfSales = $this->result->hasRole('Sales');
        $navTab = [
                ['title' => 'Info' , 'link' => '/user/'.$this->data_id , 'status' => '1'],
        ];
        if($boolPermissionsChangePW){
            $navTab[] = ['title' => 'Edit' , 'link' => '/user/'.$this->data_id.'/edit' , 'status' => '0'];
            $navTab[] = ['title' => 'Change password' , 'link' => '/user/'.$this->data_id.'/editpassword' , 'status' => '0'];
        }
        if($boolPermissionsTarget && $boolIfSales){
            $navTab[] = ['title' => 'Edit Sales' , 'link' => '/user/'.$this->data_id.'/editsales' , 'status' => '0'];
        }
            return view('livewire.master.user.show',[

            ])
            ->layout('layouts.app', [
                'pagetitle' => [
                    ['title' => 'User' , 'link' => '/user'],
                    ['title' => $this->username , 'link' => ''],
                ],
            'navigationTab' => $navTab
            ]);
        
    }
}
