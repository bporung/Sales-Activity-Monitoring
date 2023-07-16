<?php

namespace App\Http\Traits;
use App\Models\Item;
use App\Models\ItemHasCategory;
use Illuminate\Support\Str;
use Auth;
trait ItemTrait {
    protected function createItem($state){

        // CREATE Item
        $createItem = Item::create([
            'name' => $state['name'],
            'code' => $state['code'],
            'type_id' => $state['type_id'],
            'brand_id' => $state['brand_id'],
            'is_active' => $state['is_active'],
            'unit_price' => $state['unit_price'],
            'description' => isset($state['description']) ? $state['description'] : null,
            'registered_by' => Auth::user()->id,
        ]);
        // CREATE CATEGORIES
        foreach($state['categories'] as $category){
            $createItem->itemcategories()->create([
                'category_id' => $category,
                'registered_by' => Auth::user()->id,
            ]);            
        }

        return response()->json([
            'status' => 200,
            'message' => 'Item '.$createItem->id.' has been created.',
            'redirect_link' => '/item/'.$createItem->id,
        ], 200); 
    }


    protected function editItem($state){

        // EDIT Item
        $editItem = Item::findOrFail($state['id']);
        $editItem->update([
            'name' => $state['name'],
            'code' => $state['code'],
            'type_id' => $state['type_id'],
            'brand_id' => $state['brand_id'],
            'is_active' => $state['is_active'],
            'unit_price' => $state['unit_price'],
            'description' => isset($state['description']) ? $state['description'] : null,
            'registered_by' => Auth::user()->id,
        ]);
        // CREATE CATEGORIES
        $deleteCategories = ItemHasCategory::where('item_id',$editItem->id)->whereNotIn('category_id',$state['categories'])->delete();
        foreach($state['categories'] as $category){
            if($editItem->itemcategories()->where('category_id',$category)->count()){
                continue;
            }else{
                    $editItem->itemcategories()->create([
                        'category_id' => $category,
                        'registered_by' => Auth::user()->id,
                    ]);   
            }         
        }

        return response()->json([
            'status' => 200,
            'message' => 'Item '.$state['id'].' has been updated.',
            'redirect_link' => '/item/'.$state['id'],
        ], 200); 

    }

   

}