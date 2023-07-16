<?php

namespace App\Http\Livewire\Master\Item;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ItemTrait;
use App\Http\Traits\Component\Form\AllSelectorTrait;

class Edit extends Component
{
    use AllSelectorTrait , ItemTrait;

    public $state = [];
    public $data_id;
    public $result;
    public $brands;
    public $types;
    public $selectedCategories = [];
    
    public function getBrands(){
        $rows = 'App\Models\Brand'::orderBy('name','ASC');
        return $rows->get()->toArray();
    }
    public function getTypes(){
        $rows = [
            ['id' => 1 , 'label' => 'New Car'], 
            ['id' => 2 , 'label' => 'Used Car'], 
        ];
        return $rows;
    }

    public function mount($id){
        $this->brands = $this->getBrands();
        $this->types = $this->getTypes();

        $result = 'App\Models\Item'::findOrFail($id);
        $this->data_id = $id;
        $this->result = $result;
        $this->fill(['state' => $result->toArray()]);
        $this->state['categories'] = $result->itemcategories()->pluck('category_id')->toArray();
        foreach($result->itemcategories as $cat){
        $this->selectedCategories[] = $cat->category->toArray();
        }
        
        $componentName = 'CategoryMultiSelector';
        $itemIDS = $result->itemcategories->pluck('category_id')->toArray();
        $this->setSelectorComponent($componentName , '' , $itemIDS);
    }

    public function submit()
    {
        $this->state['categories'] = $this->returnMultiSelectorComponent('CategoryMultiSelector');

        $validatedData = Validator::make(
            $this->state,
            [
                'id' => 'required',
                'type_id' => 'required',
                'brand_id' => 'required',
                'code' => 'required|unique:items,code,'.$this->data_id,
                'name' => 'required',
                'unit_price' => 'required|numeric',
                'categories' => 'required',
                'is_active' => 'required',
                'description' => 'nullable',
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
        $res = $this->editItem($this->state)->getData();
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
        return view('livewire.master.item.edit',[

        ])
        ->layout('layouts.app', [
            'pagetitle' => [
                ['title' => 'Item' , 'link' => '/item'],
                ['title' => $this->result->name , 'link' => ''],
            ],
        'navigationTab' => [
            ['title' => 'Info' , 'link' => '/item/'.$this->data_id , 'status' => '0'],
            ['title' => 'Edit' , 'link' => '/item/'.$this->data_id.'/edit' , 'status' => '1'],
        ]
        ]);
    }
}
