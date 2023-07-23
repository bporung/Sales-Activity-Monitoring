<?php

namespace App\Http\Traits;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\InteractionGroup;
use Auth;
trait CustomerTrait {

    protected function generateCustomerID($province_id){
        $getCode = 'App\Models\Province'::findOrFail($province_id);
        $code = $getCode->code;

        $getLastCustomer = Customer::orderBy('id','DESC')->where('id','LIKE',$code.'%')->first();
        if($getLastCustomer){
            $getLastIncrement = substr($getLastCustomer->id,-5);
            $setNewIncrement = str_pad(($getLastIncrement + 1),5,"0",STR_PAD_LEFT);
            $genID = $code.$setNewIncrement;
        }else{
            $genID = $code.'00001';
        }
        return $genID;

    }
    protected function createCustomer($state){

        // DEFINE ALL VARIABLE
        $location = 'App\Models\Village'::findOrFail($state['location']);
        $customer_id = $this->generateCustomerID($location->district->city->province_id);
        $coordinate = explode("/",$state['coordinate']);
        $lat = $coordinate[0];
        $lng = $coordinate[1];

        // CREATE CUSTOMER
        $createItem = Customer::create([
            'id' => $customer_id,
            'title_id' => $state['title_id'],
            'name' => $state['name'],
            'email' => isset($state['email']) ? $state['email'] : null,
            'note' => isset($state['note'])  ? $state['note'] : null,
            'address' => isset($state['address']) ? $state['address'] : null,
            'province_id' => $location->district->city->province_id, 
            'city_id' => $location->district->city_id, 
            'district_id' => $location->district_id, 
            'village_id' => $location->id, 
            'zipcode' => isset($state['zipcode']) ? $state['zipcode'] : $location->zipcode, 
            'latitude' => $lat, 
            'longitude' => $lng, 
            'pic' => isset($state['pic']) ? $state['pic'] : null, 
            'phone' => isset($state['phone']) ? $state['phone'] : null, 
            'registered_by' => Auth::user()->id,
        ]);
        // CREATE CATEGORIES
        foreach($state['categories'] as $category){
            $createItem->customercategories()->create([
                'category_id' => $category,
                'registered_by' => Auth::user()->id,
            ]);            
        }

        //  CREATE DEFAULT INTERACTION GROUP
         $createGroup = InteractionGroup::create([
            'customer_id' => $createItem->id,
            'name' => 'Default',
            'registered_by' => Auth::user()->id,
        ]);

        if(Auth::user()->hasRole('Sales')){
            $createGroup->hasusers()->create([
                'user_id' => Auth::user()->id,
            ]);
        }

         return response()->json([
             'status' => 200,
             'message' => 'Customer '.$createItem->id.' has been created.',
             'redirect_link' => '/customer/'.$createItem->id,
        ], 200); 

    }


    protected function editCustomer($state){
        
        // DEFINE ALL VARIABLE
        $location = 'App\Models\Village'::findOrFail($state['location']);
        $coordinate = explode("/",$state['coordinate']);
        $lat = $coordinate[0];
        $lng = $coordinate[1];

        $editItem = Customer::findOrFail($state['id']);
        $editItem->title_id = $state['title_id'];
        $editItem->name = $state['name'];
        $editItem->email = isset($state['email']) ? $state['email'] : null;
        $editItem->note = isset($state['note']) ? $state['note'] : null;
        $editItem->address = isset($state['address']) ? $state['address'] : null;
        $editItem->province_id = $location->district->city->province_id ;
        $editItem->city_id = $location->district->city_id ;
        $editItem->district_id = $location->district_id ;
        $editItem->village_id = $location->id;
        $editItem->zipcode = isset($state['zipcode']) ? $state['zipcode'] : null;
        $editItem->latitude = $lat;
        $editItem->longitude = $lng;
        $editItem->pic = isset($state['pic']) ? $state['pic'] : null;
        $editItem->phone = isset($state['phone']) ? $state['phone'] : null;
        $editItem->save();

        
        // CREATE CATEGORIES
        $deleteCategories = CustomerCategory::where('customer_id',$editItem->id)->whereNotIn('category_id',$state['categories'])->delete();
        foreach($state['categories'] as $category){
            if($editItem->customercategories()->where('category_id',$category)->count()){
                continue;
            }else{
                    $editItem->customercategories()->create([
                        'category_id' => $category,
                        'registered_by' => Auth::user()->id,
                    ]);   
            }         
        }


         return response()->json([
             'status' => 200,
             'message' => 'Customer '.$editItem->id.' has been updated.',
             'redirect_link' => '/customer/'.$editItem->id,
        ], 200); 

    }

}