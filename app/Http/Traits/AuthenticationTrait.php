<?php

namespace App\Http\Traits;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
trait AuthenticationTrait {

    protected $auth_status;

    protected function checkingPermissions($group_name,$group_action){
        $user = Auth::user();

        $all_action_name = $group_action.' all '.$group_name;
        if($group_action === 'create'){
            $all_action_name = $group_action.' '.$group_name;
        }

        $self_action_name = $group_action.' self '.$group_name;


        if($user->can($all_action_name)){
            $this->auth_status = 1;
        }else{
            if($user->can($self_action_name)){
                if(in_array($user->id, $userArr)){
                    $this->auth_status = 2;
                }
            }
        };

        return abort('401');

    }
    protected function userAndSubordinatesArr(){
        $user = Auth::user();

        $userArr = [];
        if(count($user->usersubordinates) > 0){
            $userArr = $user->usersubordinates->pluck('subordinate_id')->toArray();
        }

        array_push($userArr,$user->id);
        return $userArr;
    }
}