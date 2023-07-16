<?php

namespace App\Http\Livewire\Master\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;

use App\Http\Traits\CustomerTrait;
use App\Http\Traits\Component\Form\AllSelectorTrait;

use Auth;
class Create extends Component
{
    use AllSelectorTrait , CustomerTrait;

    public $state = [];

    
    public $coordinate;
    public $categories;
    public $customertitles;
    public $contacttitles;

    public function mount(){
        if(!Auth::user()->can('create all customer')){abort('401');}

        $this->getCustomerTitles();
        $this->getContactTitles();
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
        $this->state['location'] = $this->returnSingleSelectorComponent('LocationSingleSelector');
        $this->state['categories'] = $this->returnMultiSelectorComponent('CategoryMultiSelector');

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
                'pic' => 'nullable',
                'phone' => 'nullable|regex:/^[1-9][0-9]{9,}$/',
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
                'pic' => 'PIC Name',
                'phone' => 'Phone Number',
            ],
        )->validate();
        $res = $this->createCustomer($this->state)->getData();
        if($res && $res->status === 200){
            session()->flash('success', $res->message);
            if($res->redirect_link){
                return redirect()->to($res->redirect_link);
            }
        }else{
            session()->flash('error','There is some error occured');
            if($res->redirect_link){
                return redirect()->to($res->redirect_link);
            }
        }
        
    }

    public function render()
    {
        return view('livewire.master.customer.create',[

        ])
        ->layout('layouts.app', [
        'pagetitle' =>  [
            ['title' => 'Customer' , 'link' => '/customer'],
            ['title' => 'Create' , 'link' => ''],
        ]  , 
        'navigationTab' => [
            ['title' => 'all' , 'link' => '/customer' , 'status' => '0'],
            ['title' => 'create' , 'link' => '' , 'status' => '1'],
        ]
        ]);
    }
}
