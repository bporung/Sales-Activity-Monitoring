<?php

namespace App\Http\Livewire\Master\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;

use App\Http\Traits\CustomerTrait;
use App\Http\Traits\Component\Form\SelectorTrait;

use Auth;
class Create extends Component
{
    use SelectorTrait , CustomerTrait;

    public $state = [];

    
    public $coordinate;
    public $categories;
    public $customertitles;
    public $contacttitles;

    public function mount(){
        if(!Auth::user()->can('create all customer')){abort('401');}

        $this->getCategories();
        $this->getCustomerTitles();
        $this->getContactTitles();
    }
    public function getLocations($search){
        $rows = 'App\Models\Village'::orderBy('name','ASC');
        if($search){
            $rows = $rows->where(function($q) use($search){
                    $q->where('name','LIKE','%'.$search.'%')->orWhere('zipcode',$search)->orWhereHas('district',function($d) use($search){
                        $d->where('name','LIKE','%'.$search.'%')->orWhereHas('city',function($c) use($search){
                            $c->where('name','LIKE','%'.$search.'%')->orWhereHas('province',function($p) use($search){
                                $p->where('name','LIKE','%'.$search.'%');
                            });
                        });
                    });
            });
        }
        return $rows->take(30)->get();
    }

    public function getCategories(){
        $rows = 'App\Models\Category'::orderBy('id','ASC')->where('group','CustomerCategory');
        $this->categories =  $rows->get()->toArray();
    }
    public function getCustomerTitles(){
        $rows = 'App\Models\Category'::orderBy('id','ASC')->where('group','CustomerTitle');
        $this->customertitles =  $rows->get()->toArray();
    }
    public function getContactTitles(){
        $rows = 'App\Models\Category'::orderBy('name','ASC')->where('group','ContactTitle');
        $this->contacttitles =  $rows->get()->toArray();
    }

    public function submit()
    {

        $this->state['coordinate'] = $this->coordinate;
        $this->state['location'] = $this->returnSelectorComponent('locations');
        $this->state['categories'] = $this->returnSelectorComponent('categories');

        $validatedData = Validator::make(
            $this->state,
            [
                'title_id' => 'required',
                'name' => 'required',
                'categories' => 'required',
                'email' => 'nullable|email',
                'note' => 'nullable',
                'address' => 'required',
                'location' => 'required',
                'zipcode' => 'nullable',
                'coordinate' => 'required',
                'contact.title_id' => 'required',
                'contact.name' => 'required',
                'contact.phone' => 'nullable|regex:/^[1-9][0-9]{9,}$/',
                'contact.email' => 'nullable|email',
                'contact.description' => 'nullable',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'email' => ':attribute bukan email valid',
                'regex' => ':attribute format tidak valid',
            ],
            [
                'title_id' => 'Title',
                'name' => 'Name',
                'categories' => 'Categories',
                'email' => 'Email',
                'address' => 'Address',
                'note' => 'Note',
                'location' => 'Location',
                'zipcode' => 'Zipcode',
                'coordinate' => 'Coordinate',
                'contact.title_id' => 'Title',
                'contact.name' => 'Name',
                'contact.phone' => 'Phone Number',
                'contact.email' => 'Email',
                'contact.description' => 'Description',
            ],
        )->validate();
        $res = $this->createCustomer($this->state)->getData();
        if($res && $res->status === 200){
            dd($res->message);
        }else{
            dd('FAIL');
        }
        
    }

    public function render()
    {
        return view('livewire.master.customer.create',[

        ])
        ->layout('layouts.app', ['pagetitle' => 'Customer / Create' , 
        'navigationTab' => [
            ['title' => 'all' , 'link' => '/customer' , 'status' => '0'],
            ['title' => 'create' , 'link' => '/customer/create' , 'status' => '1'],
        ]
        ]);
    }
}
