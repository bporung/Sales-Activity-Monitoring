<?php

namespace App\Http\Traits;
use App\Models\InteractionGroup;

use Auth;
trait InteractionGroupTrait {

    protected function paginateInteractionGroups($customer_id,$search,$isActive,$notActive,$current_page,$per_page){
        $results = InteractionGroup::orderBy('status','DESC');
        $results = $results->where('customer_id',$customer_id);
        if($search){
            $results = $results->where(function($q) use($search){
                $q->orWhere('name','LIKE','%'.$search.'%')->orWhere('description','LIKE','%'.$search.'%');
            });
        }
        
        if($isActive || $notActive){
            $results = $results->where(function($q) use($notActive,$isActive){
                if($isActive){
                    $q->orWhere('status','1');
                }
                if($notActive){
                    $q->orWhere('status','0');
                }
            });
        }
        $results = $results->paginate($per_page, ['*'], 'page', $current_page);

        return $results;
    }
    protected function getInteractionGroup($id){
        $result = InteractionGroup::findOrFail($id);
        return $result;
    }
    protected function createInteractionGroup($state){
        // CREATE INTERACTIONGROUP
        $createItem = InteractionGroup::create([
            'customer_id' => $state['customer_id'],
            'name' => $state['name'],
            'description' => isset($state['description']) ? $state['description'] : '',
            'registered_by' => Auth::user()->id,
        ]);
        // CREATE DETAILS
        foreach($state['users'] as $userid){
            $createItem->hasusers()->create([
                'user_id' => $userid,
            ]);
        }


         return response()->json([
             'status' => 200,
             'message' => 'Group '.$createItem->name.' has been created.',
             'redirect_link' => '/customer/'.$createItem->customer_id.'/interactiongroup/'.$createItem->id,
        ], 200);

    }

    protected function editInteractionGroup($state){

        // CREATE INTERACTIONGROUP
        $createItem = InteractionGroup::findOrFail($state['id']);
        $createItem->name =  $state['name'];
        $createItem->description =  isset($state['description']) ? $state['description'] : '';
        $createItem->updated_by =  Auth::user()->id;
        $createItem->save();

        $createItem->hasusers()->whereNotIn('user_id',$state['hasusers'])->delete();

        foreach($state['hasusers'] as $userid){
            if($createItem->hasusers()->where('user_id',$userid)->count()){
                continue;
            }else{
                $createItem->hasusers()->create(['user_id' => $userid]);
            }
        }

         return response()->json([
             'status' => 200,
             'message' => 'Group '.$createItem->name.' has been updated.',
             'redirect_link' => '/customer/'.$createItem->customer_id.'/interactiongroup/'.$createItem->id,
        ], 200); 

    }



}