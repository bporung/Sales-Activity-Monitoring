<?php

namespace App\Http\Traits;
use App\Models\Interaction;
use App\Models\InteractionGroup;
use Illuminate\Support\Str;

use Auth;
trait InteractionTrait {

    protected function paginateInteractions($customer_id,$group_id,$search,$current_page,$per_page){
        $results = Interaction::with(['type','group','customer','stage','registered','details.item'])->orderBy('created_at','DESC');
        if($customer_id){
        $results = $results->where('customer_id',$customer_id);
        }
        if($group_id){
        $results = $results->where('group_id',$group_id);
        }
        if($search){
            $results = $results->where('description','LIKE','%'.$search.'%');
        }
        $results = $results->paginate($per_page, ['*'], 'page', $current_page);

        return $results;
    }
    protected function getInteraction($id){
        $result = Interaction::findOrFail($id);
        return $result;
    }
    protected function createInteraction($state){
        // CREATE GROUP IF NEEDED
        if(isset($state['createNewGroup']) && $state['createNewGroup'] === true){
            $createGroup = InteractionGroup::create([
                'customer_id' => $state['customer_id'],
                'name' => $state['group_name'],
                'registered_by' => Auth::user()->id,
            ]);
            $group_id = $createGroup->id;
        }else{
            $group_id = $state['group_id'];
        }

        // CREATE INTERACTION
        $createItem = Interaction::create([
            'customer_id' => $state['customer_id'],
            'type_id' => $state['type_id'],
            'group_id' => $group_id,
            'stage_id' => $state['stage_id'],
            'description' => $state['description'],
            'registered_by' => Auth::user()->id,
        ]);
        // CREATE DETAILS
        foreach($state['details'] as $detail){
            if(isset($detail['item_id']) && $detail['item_id']){
                $createItem->details()->create([
                    'item_id' => $detail['item_id'],
                    'qty' => isset($detail['qty']) && $detail['qty'] ? $detail['qty'] : 1,
                    'unit_price' => isset($detail['unit_price']) && $detail['unit_price'] ? $detail['unit_price'] : null,
                ]);      
            }
        }

        if(isset($state['images']) && $state['images']){
            foreach($state['images'] as $image){
                $image_path = $image->storeAs('public/interaction/'.$createItem->id,\Carbon\Carbon::now()->format('Y-m-d_H-i-s') . '.' . $image->getClientOriginalExtension());
                $setPath = '/storage'.Str::substr($image_path,6);
                $createImage = $createItem->images()->create([
                    'image' => $setPath,
                ]);
            }
        }


        
        create_notification_by_type('create_interaction',$createItem);


         return response()->json([
             'status' => 200,
             'message' => 'Interaction '.$createItem->id.' has been created.',
             'redirect_link' => '/customer/'.$createItem->customer_id.'/interaction/'.$createItem->id,
        ], 200); 

    }

    protected function editInteraction($state){
        // CREATE GROUP IF NEEDED
        if(isset($state['createNewGroup']) && $state['createNewGroup'] === true){
            $createGroup = InteractionGroup::create([
                'customer_id' => $state['customer_id'],
                'name' => $state['group_name'],
                'registered_by' => Auth::user()->id,
            ]);
            $group_id = $createGroup->id;
        }else{
            $group_id = $state['group_id'];
        }

        // CREATE INTERACTION
        $createItem = Interaction::findOrFail($state['id']);
        $updateItem = $createItem->update([
            'type_id' => $state['type_id'],
            'group_id' => $group_id,
            'stage_id' => $state['stage_id'],
            'description' => $state['description'],
            'updated_by' => Auth::user()->id,
        ]);
        // CREATE DETAILS
        foreach($state['details'] as $detail){
            if(isset($detail['item_id']) && $detail['item_id']){
                $createItem->details()->create([
                    'item_id' => $detail['item_id'],
                    'qty' => isset($detail['qty']) && $detail['qty'] ? $detail['qty'] : 1,
                    'unit_price' => isset($detail['unit_price']) && $detail['unit_price'] ? $detail['unit_price'] : null,
                ]);      
            }
        }

        if(isset($state['images']) && $state['images']){
            $createImage = $createItem->images()->delete();
            foreach($state['images'] as $image){
                $image_path = $image->storeAs('public/interaction/'.$createItem->id,\Carbon\Carbon::now()->format('Y-m-d_H-i-s') . '.' . $image->getClientOriginalExtension());
                $setPath = '/storage'.Str::substr($image_path,6);
                $createImage = $createItem->images()->create([
                    'image' => $setPath,
                ]);
            }
        }

        
        
        create_notification_by_type('edit_interaction',$createItem);

         return response()->json([
             'status' => 200,
             'message' => 'Interaction '.$createItem->id.' has been updated.',
             'redirect_link' => '/customer/'.$createItem->customer_id.'/interaction/'.$createItem->id,
        ], 200); 

    }

    protected function finalizeInteraction($state){
        $finalizeItem = Interaction::findOrFail($state['id']);
        $updateItem = $finalizeItem->update([
            'finalized_at' => now(),
            'finalized_by' => Auth::user()->id,
        ]);
        $updateGroup = $finalizeItem->group()->update([
            'lastinteraction_at' => $finalizeItem->created_at,
        ]);

        
        create_notification_by_type('finalize_interaction',$finalizeItem);

        return response()->json([
            'status' => 200,
            'message' => 'Interaction '.$finalizeItem->id.' has been finalized.',
            'redirect_link' => '/customer/'.$finalizeItem->customer_id.'/interaction/'.$finalizeItem->id,
       ], 200); 
    }


}