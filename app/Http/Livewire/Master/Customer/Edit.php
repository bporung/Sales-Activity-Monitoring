<?php

namespace App\Http\Livewire\Master\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;

use App\Http\Traits\CustomerTrait;
use App\Http\Traits\Component\Form\AllSelectorTrait;
class Edit extends Component
{
    use AllSelectorTrait , CustomerTrait;

    public $data_id;
    public $state = [];
    public $selectedLocation;
    public $coordinate;
    public $old_location = [];

    
    public $categories;
    public $customertitles;
    
    public $selectedCategories = [];
    

    public function getCustomerTitles(){
        $rows = 'App\Models\Category'::orderBy('id','ASC')->where('group','CustomerTitle');
        $this->customertitles =  $rows->get()->toArray();
    }
    public function mount($id){
        $this->data_id = $id;
        $this->getCustomerTitles();
        
        $customer = 'App\Models\Customer'::findOrFail($id);
        $this->state = 
            [
                'id' => $id,
                'title_id' => $customer->title_id,
                'name' => $customer->name,
                'categories' => $customer->customercategories()->pluck('category_id')->toArray(),
                'email' => $customer->email,
                'note' => $customer->note,
                'address' => $customer->address,
                'village_id' => $customer->village_id,
                'village' => $customer->village,
                'location' => $customer->village->toArray(),
                'coordinate' => $customer->latitude.'/'.$customer->longitude,
                'village' => $customer->village,
                'zipcode' => $customer->zipcode,
                'pic' => $customer->pic,
                'phone' => $customer->phone,
            ];
        $this->coordinate = $customer->latitude.'/'.$customer->longitude;
        $this->selectedCategories = $customer->categories->toArray();
        $this->selectedLocation = $customer->village->toArray();
        
        $componentName = 'CategoryMultiSelector';
        $itemIDS = $customer->categories->pluck('code')->toArray();
        $this->setSelectorComponent($componentName , '' , $itemIDS);

        $componentLocationName = 'LocationSingleSelector';
        $itemIDSs = [$customer->village_id];
        $this->setSelectorComponent($componentLocationName , '' , $itemIDSs);
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
                'note' => 'Note',
                'location' => 'Location',
                'zipcode' => 'Zipcode',
                'coordinate' => 'Coordinate',
                'pic' => 'PIC Name',
                'phone' => 'Phone Number',
            ],
        )->validate();

        
        $res = $this->editCustomer($this->state)->getData();
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
        return view('livewire.master.customer.edit',[

        ])
        ->layout('layouts.app', [
        'pagetitle' => [
            ['title' => 'Customer' , 'link' => '/customer'],
            ['title' => $this->data_id , 'link' => '/customer/'.$this->data_id],
        ], 
        'navigationTab' => [
            ['title' => 'Info' , 'link' => '/customer/'.$this->data_id , 'status' => '0'],
            ['title' => 'Edit' , 'link' => '' , 'status' => '1'],
        ]
        ]);
    }
}
