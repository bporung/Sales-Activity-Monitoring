<?php

namespace App\Http\Livewire\Master\Item;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ItemTrait;
use App\Http\Traits\Component\Form\AllSelectorTrait;

class Create extends Component
{
    use AllSelectorTrait , ItemTrait;

    public $state = [];
    public $brands;
    public $types;
    
    public function getBrands(){
        $rows = 'App\Models\Brand'::orderBy('name','ASC');
        return $rows->get()->toArray();
    }
    public function getTypes(){
        $rows = [
            ['id' => 1 , 'label' => 'Machine'], 
            ['id' => 2 , 'label' => 'Supply'], 
            ['id' => 3 , 'label' => 'Part'], 
            ['id' => 4 , 'label' => 'Accessories'], 
            ['id' => 5 , 'label' => 'Tool'], 
            ['id' => 6 , 'label' => 'Package'], 
            ['id' => 7 , 'label' => 'Other'], 
        ];
        return $rows;
    }

    public function mount(){
        $this->brands = $this->getBrands();
        $this->types = $this->getTypes();

    }

    public function submit()
    {
        $this->state['categories'] = $this->returnMultiSelectorComponent('CategoryMultiSelector');

        $validatedData = Validator::make(
            $this->state,
            [
                'type_id' => 'required',
                'brand_id' => 'required',
                'code' => 'required|unique:items,code',
                'name' => 'required',
                'categories' => 'required',
                'is_active' => 'required',
                'description' => 'nullable',
                'unit_price' => 'required|numeric',
            ],
            [
                'required' => ':attribute tidak boleh kosong',
                'unique' => ':attribute harus unique , :attribute telah digunakan',
            ],
            [
                'type_id' => 'Type',
                'brand_id' => 'Brand',
                'code' => 'Code',
                'name' => 'Name',
                'description' => 'Description',
                'unit_price' => 'Unit Price',
                'is_active' => 'Status',
            ],
        )->validate();
        $res = $this->createItem($this->state)->getData();
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
        return view('livewire.master.item.create',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Item' , 'link' => '/item'],
                ['title' => 'Create' , 'link' => ''],
            ],
        'navigationTab' => [
            ['title' => 'all' , 'link' => '/item' , 'status' => '0'],
            ['title' => 'create' , 'link' => '/item/create' , 'status' => '1'],
        ]
        ]);
    }
}
