<?php

use App\Models\Notification;
use App\Models\NotificationReader;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if(!function_exists('create_notification')){

    function create_notification($subject,$description,$link,$permissions = [], $roles = [], $readers = []){
        $user = Auth::user();

        $createItem = Notification::create([
            'subject' => $subject,
            'description' => $description,
            'link' => $link,
        ]);
        $users = [];
        $userRoles = [];
        $userPermissions = [];
        $useRoles = $roles;
        $useRoles[] = 'Super Admin';
        if($readers){
            $users = User::whereIn('id',$readers)->get();
            if($users->count()){
                $users = $users->pluck('id')->toArray();
            }else{
                $users = [];
            }
        }
        if($roles){
            $userRoles = User::role($roles)->get();
            if($userRoles->count()){
                $userRoles = $userRoles->pluck('id')->toArray();
            }else{
                $userRoles = [];
            }
        }
        if($permissions){
            $userPermissions = User::permission($permissions)->get();
            if($userPermissions->count()){
                $userPermissions = $userPermissions->pluck('id')->toArray();
            }else{
                $userPermissions = [];
            }
        }

        $array_first = array_unique(array_merge($users,$userRoles), SORT_REGULAR);
        $array_all = array_unique(array_merge($array_first,$userPermissions), SORT_REGULAR);

        foreach($array_all as $userID){
            $createReader = $createItem->readers()->create([
                'user_id' => $userID,
            ]);
        }

        return true;
    }

}