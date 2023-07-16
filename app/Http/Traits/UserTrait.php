<?php

namespace App\Http\Traits;
use App\Models\User;
use App\Models\UserSubordinate;
use Illuminate\Support\Facades\Hash;
use Auth;
trait UserTrait {
    protected function createUser($state){
        $sales_target = NULL;
        $interaction_target = NULL;
        $customer_target = NULL;

        if ($state['role_id'] == '3'){
            $sales_target = 7000000000;
            $interaction_target = 300;
            $customer_target = 200;
        }
        // CREATE User
        $createItem = User::create([
            'name' => $state['name'],
            'username' => $state['username'],
            'password' => Hash::make($state['password']),
            'email' => isset($state['email']) ? $state['email'] : null,
            'sales_target' => $sales_target,
            'interaction_target' => $interaction_target,
            'customer_target' => $customer_target,
        ]);
        $createItem->syncRoles([$state['role_id']]);

        return response()->json([
            'status' => 200,
            'message' => 'User '.$createItem->id.' has been created.',
            'redirect_link' => '/user/'.$createItem->id,
        ], 200); 
    }


    protected function editUser($state){

        $sales_target = NULL;
        $interaction_target = NULL;
        $customer_target = NULL;

        if ($state['role_id'] == '3'){
            $sales_target = 7000000000;
            $interaction_target = 300;
            $customer_target = 200;
        }
        // EDIT User
        $editItem = User::findOrFail($state['id']);
        $updateItem = $editItem->update([
            'name' => $state['name'],
            'username' => $state['username'],
            'email' => isset($state['email']) ? $state['email'] : null,
            'sales_target' => $sales_target,
            'interaction_target' => $interaction_target,
            'customer_target' => $customer_target,
        ]);
        $editItem->syncRoles([$state['role_id']]);

        return response()->json([
            'status' => 200,
            'message' => 'User '.$editItem->id.' has been updated.',
            'redirect_link' => '/user/'.$editItem->id,
        ], 200); 

    }

    protected function editSales($state){

        $sales_target = NULL;
        $interaction_target = NULL;
        $customer_target = NULL;

        if ($state['role_id'] == '3'){
            $sales_target = $state['sales_target'];
            $interaction_target = $state['interaction_target'];
            $customer_target = $state['customer_target'];
        }
        // EDIT User
        $editItem = User::findOrFail($state['id']);
        $updateItem = $editItem->update([
            'name' => $state['name'],
            'username' => $state['username'],
            'email' => isset($state['email']) ? $state['email'] : null,
            'sales_target' => $sales_target,
            'interaction_target' => $interaction_target,
            'customer_target' => $customer_target,
        ]);
        $editItem->syncRoles([$state['role_id']]);

        return response()->json([
            'status' => 200,
            'message' => 'User '.$editItem->id.' has been updated.',
            'redirect_link' => '/user/'.$editItem->id,
        ], 200); 

    }

    protected function editPasswordUser($state){

        // EDIT User
        $editItem = User::findOrFail($state['id']);
        $updateItem = $editItem->update([
            'password' => Hash::make($state['password']),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'User '.$editItem->id.' password has been updated.',
            'redirect_link' => '/user/'.$editItem->id,
        ], 200); 

    }
    protected function editSubordinateUser($state){

        // EDIT User
        $editItem = User::findOrFail($state['id']);
        
        $deleteCategories = UserSubordinate::where('user_id',$editItem->id)->whereNotIn('subordinate_id',$state['subordinates'])->delete();
        foreach($state['subordinates'] as $subordinate){
            if($editItem->usersubordinates()->where('subordinate_id',$subordinate)->count()){
                continue;
            }else{
                    $editItem->usersubordinates()->create([
                        'subordinate_id' => $subordinate,
                        'registered_by' => Auth::user()->id,
                    ]);   
            }         
        }

        return response()->json([
            'status' => 200,
            'message' => 'User '.$editItem->id.' subordinate(s) has been updated.',
            'redirect_link' => '/user/'.$editItem->id,
        ], 200); 

    }

}